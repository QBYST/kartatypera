<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyPickTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'teams',
        'riders',
        'h2hs',
        'week',
        'closes_at',
    ];

    public function weeklyBets(){
        return $this->hasMany(WeeklyBet::class);
    }
}
