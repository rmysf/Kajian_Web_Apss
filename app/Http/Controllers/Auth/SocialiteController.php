<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect user to Google OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();
                        
            if ($user) {
                // Jika user sudah ada (misal sebelumnya daftar manual), update google_id-nya
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                // Jika belum pernah daftar sama sekali, buat user baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, // Password tidak diisi karena menggunakan Google
                    'role' => 'user',
                    'photo' => $googleUser->getAvatar(),
                ]);
            }
            
            // Otomatis login
            Auth::login($user, true); // true = remember me
            
            // Arahkan ke beranda (homepage)
            return redirect('/')->with('status', 'Berhasil masuk dengan akun Google!');
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal masuk dengan akun Google. Silakan coba lagi.');
        }
    }
}
