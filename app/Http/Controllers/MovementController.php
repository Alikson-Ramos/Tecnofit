<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    public function ranking(int $movementId): JsonResponse
    {
        $movement = Movement::find($movementId);

        if (!$movement) {
            return response()->json(['message' => 'Movement not found'], 404);
        }

        $maxValues = DB::table('personal_records')
            ->select('user_id', DB::raw('MAX(value) as max_value'))
            ->where('movement_id', $movement->id)
            ->groupBy('user_id');

        $records = DB::table('personal_records as pr')
            ->select('pr.user_id', 'pr.value', 'pr.date')
            ->joinSub($maxValues, 'mv', function ($join) {
                $join->on('pr.user_id', '=', 'mv.user_id')
                    ->whereColumn('pr.value', '=', 'mv.max_value');
            })
            ->where('pr.movement_id', $movement->id)
            ->orderByDesc('pr.value')
            ->orderBy('pr.date')
            ->orderBy('pr.user_id')
            ->get();

        $userIds = $records->pluck('user_id')->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $ranking = [];
        $currentRank = 1;
        $position = 1;
        $previousValue = null;

        foreach ($records as $record) {
            $user = $users[$record->user_id] ?? null;
            if (!$user) continue;

            if ($previousValue !== null && $record->value < $previousValue) {
                $currentRank = $position;
            }

            $ranking[] = [
                'position' => $currentRank,
                'user' => $user->name,
                'value' => (float) $record->value,
                'date' => $record->date,
            ];

            if ($previousValue === null || $record->value < $previousValue) {
                $position = $currentRank + 1;
            }

            $previousValue = $record->value;
        }

        return response()->json([
            'movement' => $movement->name,
            'ranking' => $ranking,
        ]);
    }
}
