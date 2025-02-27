<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\WeeklyPickTemplate;
use App\Models\WeeklyPickOutcome;
use App\Models\WeeklyBet;
use App\Models\WeeklyPick;
use App\Models\User;
use App\Models\Bet;
use App\Models\Head2Head;
use App\Models\Result;
use App\Models\Score;


class WeeklyPickOutcomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = WeeklyPickTemplate::all();

        $outcomes = [];
        foreach ($templates as $template) {
            $outcome = WeeklyPickOutcome::where('weekly_pick_template_id', $template->id)->first();
            if ($outcome) {
                $outcomes[] = $outcome;
            } else {
                $outcomes[] = "-";
            }
        }
        


        return view('weeklyPickOutcomeCenter', [
            'templates' => $templates,
            'outcomes' => $outcomes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Function for calculating points after setting outcomes
     */

    public function calc_points($weeklyPickTemplate, $result, $scores, $h2hs, $bets)
    {
        $userPicks = WeeklyPick::where('week', $weeklyPickTemplate->week)->get();

        $finalPoints;

        // obliczanie punktow dla danego gracza
        foreach ($userPicks as $pick) {
            // obliczenie punktow z wyniku
            $finalPoints = 0;
            $points = 0;
            // pobranie rekordu z wynikiem
            $resultPick = Result::where("weekly_pick_id", $pick->id)->first();
            if ($resultPick) {
                // jesli trafi wynik
                if ($resultPick->prediction_home == $result[0] && $resultPick->prediction_away == $result[1]) {
                    $points = 50;
                }
                // jesli nie trafi wyniku
                else {
                    $points = 50;
                    // predykcja gospodarza
                    $points -= abs($resultPick->prediction_home - $result[0]) * 2;

                    // predykcja goscia
                    $points -= abs($resultPick->prediction_away - $result[1]) * 2;
                }
                
            } 
            // zapis punktow z wyniku
            $resultPick->update(['points' => $points]);

            $finalPoints += $points;


            // obliczanie punktow z wyniku driverow
            $points = 0;
            // pobranie rekordu z driverami
            $scorePick = Score::where("weekly_pick_id", $pick->id)->first();
            if ($scorePick) {
                // pobranie predykcji gracza
                $tableHome = json_decode($scorePick->home);
                $tableAway = json_decode($scorePick->away);
                $captain = $scorePick->selected_captain;

                // przejscie przez wszystkie wyniki
                foreach ($scores as $index => $score) {
                    // lokalne punkty
                    $points_ind = 0;

                    // home
                    if ($index < 8) {
                        // jesli trafi punkty
                        if ($tableHome[$index] == $score) {
                            $points_ind = 5;
                        // jesli nie trafi
                        } else {
                            $points_ind = 3 - abs(intval($tableHome[$index]) - intval($score));
                        }
                    // away
                    } else {
                        // jesli trafi punkty
                        if ($tableAway[$index - 8] == $score) {
                            $points_ind = 5;
                        // jesli nie trafi
                        } else {
                            $points_ind = 3 - abs(intval($tableAway[$index - 8]) - intval($score));
                        }
                    }
                    
                    // czy kapitan
                    if ($index == $captain) {
                        $points_ind *= 2;
                    }

                    // sumowanie do kupy
                    $points += $points_ind;
                }
            }
            
            // zapis punktow z driverow
            $scorePick->update(['points' => $points]);

            $finalPoints += $points;


            // obliczanie punktow z h2h
            $points = 0;

            // pobranie rekordu z h2h
            $h2hPick = Head2Head::where("weekly_pick_id", $pick->id)->first();
            if ($h2hPick) {
                // pobranie predykcji gracza
                $picks = json_decode($h2hPick->picks);

                // ile poprawnych
                $correct_counter = 0;

                // przejscie przez wszystkie wyniki
                foreach ($picks as $index => $h2hpick) {
                    if ($h2hpick == $h2hs[$index]) {
                        $correct_counter += 1;
                        $points += 5;
                    }
                }

                // za trafienie 5
                if ($correct_counter == 5) {
                    $points += 5;
                }
            }

            // zapis punktow z h2h
            $h2hPick->update(['points' => $points]);

            $finalPoints += $points;


            // obliczanie punktow z betow
            $points = 0;

            // pobranie rekordu z betami
            $betPick = Bet::where("weekly_pick_id", $pick->id)->first();
            if ($betPick) {
                // pobranie predykcji gracza
                $playerBets = json_decode($betPick->bets);
                $betOdds = json_decode($betPick->odds);

                $current_multi = 1;

                foreach ($playerBets as $index => $one_bet) {
                    if ($one_bet == $bets[$index]){
                        $current_multi *= floatval($betOdds[$index]);
                    }
                    else if ($bets[$index] == '-' || $one_bet == null) {
                        $current_multi *= 1;
                    }
                    else {
                        $current_multi = -1;
                        break;
                    }
                }

                $points = $betPick->bet_amount * $current_multi;
            }

            $betPick->update(['points' => $points]);


            $finalPoints += $points;

            // aktualizacja punktow usera, odjecie starych i dodanie nowych
            $user = User::where("id", $pick->user_id)->first();
            // $user->points -= $pick->points; 

            $userPoints = $user->points - $pick->points;
            
            $userPoints += $finalPoints;

            $user->update(['points' => $userPoints]);

            $pick->update(['points' => $finalPoints]);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // wynik (zakodowane bo wynik moze byc 44-45 np)
        // if(($request->input('home') + $request->input('away')) != 90)
        // {
        //     return redirect()->back()->withErrors(['total' => 'Suma punktów gospodarzy i gości musi być równa 90'])->withInput();
        // }

        // punkty zawodnikow - walidacja
        $sum_home = $request->input('home1') + $request->input('home2') + $request->input('home3') + $request->input('home4') + $request->input('home5') + $request->input('home6') + $request->input('home7') + $request->input('home8');
        $sum_away = $request->input('away1') + $request->input('away2') + $request->input('away3') + $request->input('away4') + $request->input('away5') + $request->input('away6') + $request->input('away7') + $request->input('away8');

        if($request->input('home') != $sum_home){
            return redirect()->back()->withErrors(['home_total' => 'Suma punktów zawodników gospodarzy musi być równa wynikowi tego zespołu'])->withInput();
        }

        if($request->input('away') != $sum_away){
            return redirect()->back()->withErrors(['away_total' => 'Suma punktów zawodników gości musi być równa wynikowi tego zespołu'])->withInput();
        }

        // tydzien
        $week = $request->input('week');

        // $exists = WeeklyPickOutcome::where('week', $week)->exists();
        // if ($exists){
        //     return redirect()->back()->withErrors(['week_rep' => 'Wyniki wybranego tygodnia juz istnieją w bazie, możesz je edytować, lub usunąć'])->withInput();
        // }

        // template
        $weeklyPickTemplate = WeeklyPickTemplate::where('week', $week)->firstOrFail();
        if (!$weeklyPickTemplate)
        {
            return redirect()->back()->withErrors(['week_error' => 'Nie istnieje template do wybranego tygodnia'])->withInput();
        }
        

        // wynik
        $result = [$request->input('home'), $request->input('away')];

        // wyniki zawodnikow
        $scores = [];

        for($i=1; $i <= 8; $i++){
            $score = $request->input("home{$i}");
            if($score != null){
                $scores[] = $score;
            }
        }

        for($i=1; $i <= 8; $i++){
            $score = $request->input("away{$i}");
            if($score != null){
                $scores[] = $score;
            }
        }

        // h2h
        $h2hs = [];

        for($i=1; $i <= 5; $i++){
            $winner = $request->input("duel{$i}");
            if ($winner != null){
                $h2hs[] = $winner;
            }
        }

        // bety
        $bets = [];
        
        for($i=1; $i <= 8; $i++){
            $bet = $request->input("bet{$i}");
            if ($bet != null){
                $bets[] = $bet;
            }else{
                $bets[] = "-";
            }
        }

        // obliczenie i rozdanie punktow
        $this->calc_points($weeklyPickTemplate, $result, $scores, $h2hs, $bets);

        // zapis albo update bazy
        $weeklyPickOutcome = WeeklyPickOutcome::updateOrCreate(
            ['week' => $week], // Kryteria wyszukiwania
            [ // Dane do zaktualizowania lub utworzenia
                'weekly_pick_template_id' => $weeklyPickTemplate->id,
                'team_outcomes' => json_encode($result),
                'rider_outcomes' => json_encode($scores),
                'h2h_outcomes' => json_encode($h2hs),
                'bet_outcomes' => json_encode($bets),
            ]
        );

        return redirect()->route('weekly-pick-outcome.index')->with('success', 'Dodano/zmieniono pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $week)
    {  
        $weeklyPickTemplate = WeeklyPickTemplate::where('week', $week)->firstOrFail();

        $teams = json_decode($weeklyPickTemplate->teams, true);
        $riders =json_decode($weeklyPickTemplate->riders, true);
        $h2hs = json_decode($weeklyPickTemplate->h2hs, true);

        $id = $weeklyPickTemplate->id;

        $weeklyBets = WeeklyBet::where('weekly_pick_template_id', $id)->get();
        $betTexts = [];
        $oddYes = [];
        $oddNo = [];

        foreach ($weeklyBets as $bet) {
            $betTexts[] = $bet->bet_text;
            $oddYes[] = $bet->odd_yes;
            $oddNo[] = $bet->odd_no;
        }

        // wczytanie do edycji
        $result = null;
        $scores = null;
        $h2h_outcomes = null;
        $bets = null;

        $weeklyPickOutcome = WeeklyPickOutcome::where('weekly_pick_template_id', $weeklyPickTemplate->id)->first();

        if ($weeklyPickOutcome) {
            $result = json_decode($weeklyPickOutcome->team_outcomes);
            $scores = json_decode($weeklyPickOutcome->rider_outcomes);
            $h2h_outcomes = json_decode($weeklyPickOutcome->h2h_outcomes);
            $bets = $weeklyPickOutcome->bet_outcomes;
        }

        return view('weeklyPickOutcome', [
            'week' => $week,
            'teams' => $teams,
            'riders' => $riders,
            'h2hs' => $h2hs,
            'betText' => $betTexts,
            'oddYes' => $oddYes,
            'oddNo' => $oddNo,
            'result' => $result,
            'scores' => $scores,
            'h2h_outcomes' => $h2h_outcomes,
            'bets' => $bets,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $week)
    {
        $userPicks = WeeklyPick::where('week', $week)->get();

        // obliczanie punktow dla danego gracza
        foreach ($userPicks as $pick) {

            $user = User::where("id", $pick->user_id)->first();
           
            // odjecie punktow podczas usuwania wynikow
            $userPoints = $user->points - $pick->points;

            $user->update(['points' => $userPoints]);

            $pick->update(['points' => 0]);
        }




        WeeklyPickOutcome::where('week', $week)->delete();

        return redirect()->route('weekly-pick-outcome.index')->with('success', 'Usunięto pomyślnie.');
    }


    
}