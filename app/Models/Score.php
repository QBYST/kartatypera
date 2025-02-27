<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_pick_id',
        'points',
        'home',
        'away',
        'selected_captain',
    ];

    public function weeklyPick()
    {
        return $this->belongsTo(WeeklyPick::class);
    }
}
