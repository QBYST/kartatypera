<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Showcase;

class ProfilePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $user = User::where('name', $name)->first();

        $trophies = Showcase::where('user_id', $user->id)->get();

        $trophy_names = null;
        $trophy_paths = null;

        foreach ($trophies as $index => $trophy) {
            $trophy_names[] = $trophy->name;
            $trophy_paths[] = $trophy->path;
        }


        return view('profilePage', [
            'user' => $user,
            'trophy_names' => $trophy_names,
            'trophy_paths' => $trophy_paths,
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
    public function destroy(string $id)
    {
        //
    }
}
