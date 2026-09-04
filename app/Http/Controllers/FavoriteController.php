<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Tampilkan daftar kajian yang disimpan (difavoritkan) oleh user.
     */
    public function index()
    {
        $favorites = Favorite::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.saved', compact('favorites'));
    }

    /**
     * Toggle simpan/hapus kajian dari favorit.
     */
    public function toggle(Kajian $kajian)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'Kajian dihapus dari daftar tersimpan.';
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
            ]);
            $status = 'Kajian berhasil disimpan!';
            $isFavorited = true;
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'is_favorited' => $isFavorited
            ]);
        }

        return back()->with('status', $status);
    }
}
