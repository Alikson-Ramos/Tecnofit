<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    public function getRanking(): array
    {
        return Cache::remember("movement_ranking_{$this->id}", now()->addMinutes(5), function () {
            $records = PersonalRecord::getRankingData($this->id);
            return [
                'movement' => $this->name,
                'ranking' => $this->calculatePositions($records)
            ];
        });
    }
    public function personalRecords()
    {
        return $this->hasMany(PersonalRecord::class);
    }
}
