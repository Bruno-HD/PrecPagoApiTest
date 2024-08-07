<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    const TRANSACTION_CACHE_KEY = 'precPago-transactions';
    const TRANSACTION_WINDOW = 60;
    const LIMIT_TIME_INSERT = 60;

    public function __construct()
    {
        if (!Cache::has(self::TRANSACTION_CACHE_KEY)) {
            Cache::forever(self::TRANSACTION_CACHE_KEY, []);
        }
    }

    public function store(StoreTransactionRequest $request)
    {
        $data = $request->all();
        $timestamp = new \DateTime($data['timestamp']);

        if ($timestamp > new \DateTime()) {
            return response()->json([], 422);
        }

        if ($timestamp < (new \DateTime())->modify('-' . self::LIMIT_TIME_INSERT . ' seconds')) {
            return response()->json([], 204);
        }

        $transaction = [
            'amount' => round($data['amount'], 2),
            'timestamp' => $timestamp->getTimestamp()
        ];

        Cache::lock(self::TRANSACTION_CACHE_KEY)->block(5, function () use ($transaction) {
            $transactions = Cache::get(self::TRANSACTION_CACHE_KEY, []);
            $transactions[] = $transaction;
            Cache::forever(self::TRANSACTION_CACHE_KEY, $transactions);
        });

        return response()->json([], 201);
    }

    public function index()
    {
        $transactions = Cache::get(self::TRANSACTION_CACHE_KEY, []);

        $now = (new \DateTime())->getTimestamp();
        $filtered = array_filter($transactions, function ($transaction) use ($now) {
            return $transaction['timestamp'] >= $now - self::TRANSACTION_WINDOW;
        });

        $count = count($filtered);
        $sum = array_sum(array_column($filtered, 'amount'));
        $avg = $count ? $sum / $count : 0;
        $max = $count ? max(array_column($filtered, 'amount')) : 0;
        $min = $count ? min(array_column($filtered, 'amount')) : 0;

        return response()->json([
            'sum' => number_format($sum, 2, '.', ''),
            'avg' => number_format($avg, 2, '.', ''),
            'max' => number_format($max, 2, '.', ''),
            'min' => number_format($min, 2, '.', ''),
            'count' => $count
        ]);
    }

    public function destroy()
    {
        Cache::forget(self::TRANSACTION_CACHE_KEY);
        Log::info('All transactions deleted.');
        return response()->json([], 204);
    }
}
