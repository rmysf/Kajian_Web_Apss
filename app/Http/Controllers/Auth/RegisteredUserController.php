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
use Illuminate\Validation\ValidationException;
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
     * Display the organizer registration view.
     */
    public function createOrganizer(): View
    {
        return view('auth.register-organizer');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = $request->role === 'organizer' ? 'organizer' : 'user';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        if ($role === 'organizer') {
            $organizerRules = [
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string'],
                'description' => ['nullable', 'string'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ];
            
            $organizerData = $request->validate($organizerRules);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('organizers', 'public');
            }

            \App\Models\Organizer::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $organizerData['phone'],
                'address' => $organizerData['address'],
                'description' => $organizerData['description'] ?? null,
                'logo' => $logoPath,
                'is_verified' => 0,
            ]);
        }

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan masuk ke akun Anda sesuai dengan role yang telah didaftarkan.');
    }
}
