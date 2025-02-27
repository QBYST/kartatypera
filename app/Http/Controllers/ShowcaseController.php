<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Showcase;
use Illuminate\Support\Facades\Storage;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $trophies = Showcase::orderBy("user_id")->get();

        $trophy_names = null;
        $trophy_owners = null;
        $trophy_ids = null;
        $trophy_paths = null;

        foreach ($trophies as $index => $trophy) {
            $trophy_names[] = $trophy->name;

            $user = User::where('id', $trophy->user_id)->first();
            $trophy_owners[] = $user->name;

            $trophy_ids[] = $trophy->id;

            $trophy_paths[] = $trophy->path;
        }

        return view('deleteShowcase', [
            'trophy_names' => $trophy_names,
            'trophy_owners' => $trophy_owners,
            'trophy_ids' => $trophy_ids,
            'trophy_paths' => $trophy_paths,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addShowcase');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'user' => 'required|string|max:255',
        ]);
    
        // sprawdzenie czy jest taki user
        $user = User::where('name', $request->user)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'Nie ma takiego użytkownika.']);
        }

        // dodanie zdjecia profilowego
        $trophyImage = $request->file('photo');

        $path = $trophyImage->store('trophies', 'public');

        $trophy = Showcase::create(
        [
            'user_id' => $user->id,
            'name' => $request->name,
            'path' => $path,
        ]);

        return redirect()->route('showcase.create')->with('success', 'Dodano pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $trophy = Showcase::findOrFail($id);

        // Usuń plik z dysku
        if (Storage::disk('public')->exists($trophy->path)) {
            Storage::disk('public')->delete($trophy->path);
        }

        // Usuń rekord z bazy danych
        $trophy->delete();

        // Przekierowanie lub zwrócenie odpowiedzi
        return redirect()->route('showcase.index')->with('success', 'Trophy deleted successfully.');
    }
}
