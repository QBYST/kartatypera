<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_pick_id',
        'points',
        'prediction_home',
        'prediction_away',
    ];

    public function weeklyPick()
    {
        return $this->belongsTo(WeeklyPick::class);
    }
}
