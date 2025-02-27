<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RankingController extends Controller
{
    public function show()
    { 
        // pobranie wszystkich userow
        $users = User::orderBy('points', 'desc')->get();

        $names = null;
        $points = null;
        $path = null;
        $ids = null;

        foreach ($users as $index => $user) {
            $ids[] = $user->id;
            $names[] = $user->name;    
            $points[] = $user->points;
            $paths[] = $user->profile_picture_path;
        }


        return view('ranking', [
            'ids' => $ids,
            'names' => $names,
            'points' => $points,
            'paths' => $paths,
        ]);
    }
}
