<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\KajianAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Tampilkan daftar kajian yang akan/sudah dihadiri user.
     */
    public function index()
    {
        $attendances = KajianAttendee::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.my-kajian', compact('attendances'));
    }

    /**
     * Daftar (Saya Mau Hadir) untuk sebuah kajian.
     */
    public function store(Kajian $kajian)
    {
        // Cek jika sudah terdaftar dan tidak dibatalkan
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        if ($attendee && $attendee->status !== 'cancelled') {
            return back()->with('status', 'Anda sudah terdaftar di kajian ini.');
        }

        // Cek kuota jika ada
        if ($kajian->quota !== null) {
            $registeredCount = KajianAttendee::where('kajian_id', $kajian->id)
                ->where('status', '!=', 'cancelled')
                ->count();
                
            if ($registeredCount >= $kajian->quota) {
                return back()->with('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
            }
        }

        if ($attendee) {
            // Jika sebelumnya dibatalkan, aktifkan kembali
            $attendee->update(['status' => 'registered']);
        } else {
            // Jika belum pernah daftar sama sekali
            KajianAttendee::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
                'status' => 'registered',
            ]);
        }

        return back()->with('status', 'Berhasil mendaftar! Anda akan menghadiri kajian ini.');
    }

    /**
     * Batalkan pendaftaran.
     */
    public function destroy(Kajian $kajian)
    {
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        if ($attendee) {
            $attendee->update(['status' => 'cancelled']);
            return back()->with('status', 'Pendaftaran berhasil dibatalkan.');
        }

        return back();
    }
}
