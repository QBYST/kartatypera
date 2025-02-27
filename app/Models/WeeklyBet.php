<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_pick_template_id',
        'bet_text',
        'odd_yes',
        'odd_no',
        'bet_type',
    ];

    public function week(){
        return $this->belongsTo(WeeklyPickTemplate::class);
    }
}
