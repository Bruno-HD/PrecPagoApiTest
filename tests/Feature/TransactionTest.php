<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_can_create_transaction()
    {
        $response = $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => '2023-08-07T09:59:51.312Z'
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_statistics()
    {
        $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => '2023-08-07T09:59:51.312Z'
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
        $this->postJson('/api/transactions', [
            'amount' => '12.3343',
            'timestamp' => '2023-08-07T09:59:51.312Z'
        ]);

        $response = $this->deleteJson('/api/transactions');

        $response->assertStatus(204);
    }
}
