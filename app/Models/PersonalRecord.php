<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalRecord extends Model
{
    use HasFactory;

    protected $table = 'personal_records';

    protected $casts = [
        'date' => 'datetime',
        'value' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movement()
    {
        return $this->belongsTo(Movement::class);
    }
}
