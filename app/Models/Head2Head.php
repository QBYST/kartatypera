<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Head2Head extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_pick_id',
        'points',
        'picks',
    ];

    public function weeklyPick()
    {
        return $this->belongsTo(WeeklyPick::class);
    }
}
