<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyPickOutcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_pick_template_id',
        'team_outcomes',
        'rider_outcomes',
        'h2h_outcomes',
        'bet_outcomes',
        'week',
    ];

}
