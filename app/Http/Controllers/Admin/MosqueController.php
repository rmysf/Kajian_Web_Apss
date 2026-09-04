<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $mosques = Mosque::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.mosque.index', compact('mosques', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mosque.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'required|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('mosques', 'public');
        }

        Mosque::create($validated);

        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosque $mosque)
    {
        return view('admin.mosque.edit', compact('mosque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosque $mosque)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'required|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($mosque->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($mosque->photo);
            }
            $validated['photo'] = $request->file('photo')->store('mosques', 'public');
        }

        $mosque->update($validated);

        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosque $mosque)
    {
        $mosque->delete();
        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil dihapus.');
    }
}
