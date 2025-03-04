<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MovementController extends Controller
{
    public function ranking(int $movementId): JsonResponse
    {
        try {
            $movement = Movement::findOrFail($movementId);

            $rankingData = Cache::remember("movement_ranking_{$movementId}", 300, function () use ($movement) {

                $maxValues = DB::table('personal_records')
                    ->select('user_id', DB::raw('MAX(value) as max_value'))
                    ->where('movement_id', $movement->id)
                    ->groupBy('user_id');

                $records = DB::table('personal_records as pr')
                    ->select([
                        'pr.user_id',
                        'u.name as user_name',
                        'pr.value',
                        'pr.date'
                    ])
                    ->joinSub($maxValues, 'mv', function ($join) {
                        $join->on('pr.user_id', '=', 'mv.user_id')
                            ->whereColumn('pr.value', '=', 'mv.max_value');
                    })
                    ->join('users as u', 'pr.user_id', '=', 'u.id')
                    ->where('pr.movement_id', $movement->id)
                    ->orderByDesc('pr.value')
                    ->orderBy('pr.date')
                    ->orderBy('pr.user_id')
                    ->get();

                $ranking = [];
                $currentRank = 1;
                $position = 1;
                $previousValue = null;

                foreach ($records as $record) {
                    if ($previousValue !== null && $record->value < $previousValue) {
                        $currentRank = $position;
                    }

                    $ranking[] = [
                        'position' => $currentRank,
                        'user' => $record->user_name,
                        'value' => (float) $record->value,
                        'date' => $record->date,
                    ];

                    if ($previousValue === null || $record->value < $previousValue) {
                        $position = $currentRank + 1;
                    }

                    $previousValue = $record->value;
                }

                return [
                    'movement' => $movement->name,
                    'ranking' => $ranking
                ];
            });

            return response()->json($rankingData)
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'SAMEORIGIN')
                ->header('Cache-Control', 'public, max-age=300');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Movement not found: {$movementId}");
            return response()->json(['message' => 'Movement not found'], 404);
        } catch (\Exception $e) {
            Log::error("Ranking error: {$e->getMessage()}", [
                'movement_id' => $movementId,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
