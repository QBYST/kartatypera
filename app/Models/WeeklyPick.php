<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyPick extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scores()
    {
        return $this->hasOne(Score::class);
    }
    
    public function results()
    {
        return $this->hasOne(Result::class);
    }
    
    public function head2head()
    {
        return $this->hasOne(Head2Head::class);
    }
    
    public function bets()
    {
        return $this->hasOne(Bet::class);
    }

}
