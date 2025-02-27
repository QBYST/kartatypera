<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\WeeklyPickTemplate;
use App\Models\WeeklyBet;
use App\Models\Bet;
use App\Models\Head2Head;
use App\Models\Result;
use App\Models\Score;
use App\Models\WeeklyPick;

class WeeklyPickController extends Controller
{
    public function show()
    {   
        $id = 5;
        
        $weeklyPickTemplate = WeeklyPickTemplate::findOrFail($id);

        $teams = json_decode($weeklyPickTemplate->teams, true);
        $riders =json_decode($weeklyPickTemplate->riders, true);
        $h2hs = json_decode($weeklyPickTemplate->h2hs, true);
        $week = $weeklyPickTemplate->week;
        $closes_at = $weeklyPickTemplate->closes_at;

        $weeklyBets = WeeklyBet::where('weekly_pick_template_id', $id)->get();
        $betTexts = [];
        $oddYes = [];
        $oddNo = [];

        foreach ($weeklyBets as $bet) {
            $betTexts[] = $bet->bet_text;
            $oddYes[] = $bet->odd_yes;
            $oddNo[] = $bet->odd_no;
        }


        $prediction_home = null;
        $prediction_away = null;

        $scores_home = null;
        $scores_away = null;
        $scores_captain = null;

        $h2h_picks = null;

        $bets = null;
        $bet_amount = null;
        $odds = null;


        $weeklyPick = WeeklyPick::where('user_id', Auth::id())
                        ->where('week', $week)
                        ->first();

        if ($weeklyPick) {
            $result = Result::where('weekly_pick_id', $weeklyPick->id)->first();
            if ($result) {
                $prediction_home = $result->prediction_home;
                $prediction_away = $result->prediction_away;
            }

            $scores = Score::where('weekly_pick_id', $weeklyPick->id)->first();
            if ($scores) {
                $scores_home = json_decode($scores->home, true);
                $scores_away = json_decode($scores->away, true);
                $scores_captain = $scores->selected_captain;
            }

            $h2h = Head2Head::where('weekly_pick_id', $weeklyPick->id)->first();
            if ($h2h) {
                $h2h_picks = json_decode($h2h->picks, true);
            }

            $bet = Bet::where('weekly_pick_id', $weeklyPick->id)->first();
            if ($bet) {
                $bets = $bet->bets;
                $bet_amount = $bet->bet_amount;
                $odds = $bet->odds;
            }
            
        }
        

        return view('weeklyPick', [
            'closes_at' => $closes_at,
            'week' => $week,
            'teams' => $teams,
            'riders' => $riders,
            'h2hs' => $h2hs,
            'betText' => $betTexts,
            'oddYes' => $oddYes,
            'oddNo' => $oddNo,
            'prediction_home' => $prediction_home,
            'prediction_away' => $prediction_away,
            'scores_home' => $scores_home,
            'scores_away' => $scores_away,
            'scores_captain' => $scores_captain,
            'h2h_picks' => $h2h_picks,
            'bet_amount' => $bet_amount,
            'bets' => $bets,
            'odds' => $odds,
        ]);
    }

    public function store(Request $request) 
    {
        // wynik
        if(($request->input('home') + $request->input('away')) != 90)
        {
            return redirect()->back()->withErrors(['total' => 'Suma punktów gospodarzy i gości musi być równa 90'])->withInput();
        }

        // punkty zawodnikow
        $sum_home = $request->input('home1') + $request->input('home2') + $request->input('home3') + $request->input('home4') + $request->input('home5') + $request->input('home6') + $request->input('home7') + $request->input('home8');
        $sum_away = $request->input('away1') + $request->input('away2') + $request->input('away3') + $request->input('away4') + $request->input('away5') + $request->input('away6') + $request->input('away7') + $request->input('away8');

        if($request->input('home') != $sum_home){
            return redirect()->back()->withErrors(['home_total' => 'Suma punktów zawodników gospodarzy musi być równa twojej predykcji wyniku'])->withInput();
        }

        if($request->input('away') != $sum_away){
            return redirect()->back()->withErrors(['away_total' => 'Suma punktów zawodników gości musi być równa twojej predykcji wyniku'])->withInput();
        }

        if($request->input('bet_amount') > 10){
            return redirect()->back()->withErrors(['bet_over' => 'Nie możesz obstawić więcej niż 10 pąktów'])->withInput();
        }

        if($request->input('bet_amount') < 0){
            return redirect()->back()->withErrors(['bet_under' => 'Nie możesz obsawić mniej niż 0 pąktów'])->withInput();
        }


        // glowne
        $weeklyPick = WeeklyPick::updateOrCreate([
            'user_id' => $request->user()->id,
            'week' => $request->input('week'),
        ]);

        // wynik
        Result::updateOrCreate([
            'weekly_pick_id' => $weeklyPick->id,
        ],
        [
            'prediction_home' => $request->input('home'),
            'prediction_away' => $request->input('away'),
        ]);

        // punkty driverow
        Score::updateOrCreate([
            'weekly_pick_id' => $weeklyPick->id,
        ],
        [
            'home' => json_encode(collect(range(1,8))->map(function ($i) use ($request){
                return $request->input('home' . $i);
            })),
            'away' => json_encode(collect(range(1,8))->map(function ($i) use ($request){
                return $request->input('away' . $i);
            })),
            'selected_captain' => $request->input('match'),
        ]);

        // h2h
        Head2Head::updateOrCreate([
            'weekly_pick_id' => $weeklyPick->id,
        ],
        [
            'picks' => json_encode(collect(range(1,5))->map(function ($i) use ($request){
                return $request->input('duel' . $i);
            })),
        ]);

        // bet
        Bet::updateOrCreate([
            'weekly_pick_id' => $weeklyPick->id,
        ],
        [
            'bets' => json_encode(collect(range(1,8))->map(function ($i) use ($request){
                return $request->input('bet' . $i);
            })),
            'odds' => json_encode(collect(range(1,8))->map(function ($i) use ($request){
                return $request->input('oddBet' . $i);
            })),
            'bet_amount' => $request->input('bet_amount'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Karta dodana pomyślnie.');
    }
}
