<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required',
                'confirmed', 
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/'
                ],
        ], [
            'name.required' => 'Nickname nie może być pusty.',
            'name.string' => 'Nickname musi być ciągiem znaków.',
            'name.max' => 'Nickname może mieć maksymalnie 50 znaków.',
            'name.unique' => 'Taki nickname już istnieje!',

            'email.required' => 'Email nie może być pusty.',
            'email.string' => 'Email musi być ciągiem znaków.',
            'email.lowercase' => 'Wpisując Email używaj tylko małych liter.',
            'email.email' => 'Wpisz poprawny adres Email.',
            'email.max' => 'Adres Email może mieć maksymalnie 255 znaków.',
            'email.unique' => 'Ten adres Email jest już w użyciu.',

            'password.required' => 'Hasło nie może być puste.',
            'password.confirmed' => 'Powtórzone hasło różni się.',
            'password.min' => 'Hasło musi być dłuższe od 8 znaków.',
            'password.regex' => 'Hasło musi zawierać przynajmniej jedną małą literę, jedną wielką literę, jedną cyfrę i jeden znak specjalny.'

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
