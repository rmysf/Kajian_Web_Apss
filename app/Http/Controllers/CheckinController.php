<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\KajianAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    /**
     * Handle QR Check-in scan.
     */
    public function store($uuid)
    {
        $kajian = Kajian::where('uuid', $uuid)->firstOrFail();

        // Cek jika user sudah terdaftar di kajian ini
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        if ($attendee) {
            // Update status menjadi attended
            $attendee->update([
                'status' => 'attended',
                'checked_in_at' => now(),
            ]);
        } else {
            // Jika belum daftar, otomatis daftarkan dan check-in
            // Bisa cek kuota juga di sini jika mau
            KajianAttendee::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
                'status' => 'attended',
                'checked_in_at' => now(),
            ]);
        }

        return redirect()->route('kajian.show', $kajian->slug)
            ->with('status', 'Alhamdulillah, Anda berhasil check-in kehadiran.');
    }
}
