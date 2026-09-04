<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $organizers = \App\Models\Organizer::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('email', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.organizer.index', compact('organizers', 'search'));
    }

    public function show(\App\Models\Organizer $organizer)
    {
        return view('admin.organizer.show', compact('organizer'));
    }

    public function verify(\App\Models\Organizer $organizer)
    {
        $organizer->update([
            'is_verified' => !$organizer->is_verified
        ]);
        
        return back()->with('success', 'Status verifikasi organizer berhasil diperbarui.');
    }
}
