<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kajian;

class KajianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Get kajians that are not drafts and not rejected, ordered by creation date (newest first)
        $kajians = Kajian::with('organizer')
            ->whereNotIn('status', ['draft', 'rejected'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhereHas('organizer', function ($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.kajian.index', compact('kajians', 'search'));
    }

    public function show(Kajian $kajian)
    {
        $kajian->load(['category', 'speaker', 'mosque', 'organizer']);
        return view('admin.kajian.show', compact('kajian'));
    }

    public function verify($id)
    {
        $kajian = Kajian::findOrFail($id);
        $kajian->update([
            'is_verified' => true,
        ]);

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil disetujui.');
    }

    public function reject($id)
    {
        $kajian = Kajian::findOrFail($id);
        
        $kajian->update([
            'is_verified' => false,
            'status' => 'rejected'
        ]);

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil ditolak/dibatalkan.');
    }
}
