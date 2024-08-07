<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_can_create_transaction()
    {
        $timestamp = now()->subSeconds(30)->format('Y-m-d\TH:i:s.v\Z'); // Timestamp dentro do intervalo válido

        $response = $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => $timestamp
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_statistics()
    {
        $timestamp = now()->subSeconds(30)->format('Y-m-d\TH:i:s.v\Z'); // Timestamp dentro do intervalo válido

        $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => $timestamp
        ]);

        $response = $this->getJson('/api/statistics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'sum',
                'avg',
                'max',
                'min',
                'count'
            ]);
    }

    public function test_can_delete_transactions()
    {
        $timestamp = now()->subSeconds(30)->format('Y-m-d\TH:i:s.v\Z'); // Timestamp dentro do intervalo válido

        $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => $timestamp
        ]);

        $response = $this->deleteJson('/api/transactions');

        $response->assertStatus(204);
    }

    public function test_transaction_outside_valid_interval()
    {
        $timestamp = now()->subSeconds(61)->format('Y-m-d\TH:i:s.v\Z'); // Timestamp fora do intervalo válido

        $response = $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => $timestamp
        ]);

        // Verifica se a transação não é aceita e retorna 204
        $response->assertStatus(204);
    }

    public function test_transaction_with_future_timestamp()
    {
        $timestamp = now()->addSeconds(65)->format('Y-m-d\TH:i:s.v\Z');  // Timestamp fora do intervalo válido

        $response = $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => $timestamp
        ]);

        // Verifica se a transação não é aceita e retorna 204
        $response->assertStatus(422);
    }
}
