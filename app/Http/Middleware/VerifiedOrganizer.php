<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user && $user->role === 'organizer') {
            $organizer = $user->organizer;
            
            // Jika organizer belum ada atau belum diverifikasi, arahkan ke profil
            if (!$organizer || !$organizer->is_verified) {
                return redirect()->route('organizer.profile.edit');
            }
        }

        return $next($request);
    }
}
