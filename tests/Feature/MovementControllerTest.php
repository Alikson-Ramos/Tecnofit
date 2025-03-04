<?php

namespace Tests\Feature;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MovementControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testRankingReturnsValidData()
    {
        $movement = Movement::factory()->create([
            'name' => 'Bench Press',
        ]);

        $user1 = User::factory()->create(['name' => 'Alice']);
        $user2 = User::factory()->create(['name' => 'Bob']);


        DB::table('personal_records')->insert([
            [
                'user_id'     => $user1->id,
                'movement_id' => $movement->id,
                'value'       => 100,
                'date'        => '2023-01-01',
            ],
            [
                'user_id'     => $user2->id,
                'movement_id' => $movement->id,
                'value'       => 120,
                'date'        => '2023-01-02',
            ],
            [
                'user_id'     => $user1->id,
                'movement_id' => $movement->id,
                'value'       => 110,
                'date'        => '2023-01-03',
            ],
        ]);

        $response = $this->getJson("/api/movements/{$movement->id}/ranking");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'movement',
            'ranking' => [
                '*' => [
                    'position',
                    'user',
                    'value',
                    'date',
                ],
            ],
        ]);

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Cache-Control', 'max-age=300, public');

        $ranking = $response->json('ranking');

        $this->assertEquals('Bob', $ranking[0]['user']);
        $this->assertEquals(120, $ranking[0]['value']);

        $this->assertEquals('Alice', $ranking[1]['user']);
        $this->assertEquals(110, $ranking[1]['value']);
    }

    public function testRankingReturnsNotFoundForInvalidMovement()
    {
        $invalidMovementId = 9999;
        $response = $this->getJson("/api/movements/{$invalidMovementId}/ranking");

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Movement not found',
        ]);
    }
}
