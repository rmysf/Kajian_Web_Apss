<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $speakers = Speaker::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.speaker.index', compact('speakers', 'search'));
    }

    public function create()
    {
        return view('admin.speaker.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.mimes' => 'Format foto harus berupa: jpeg, png, jpg, atau gif.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal adalah 2MB.',
            'name.required' => 'Nama pemateri wajib diisi.',
            'name.max' => 'Nama pemateri maksimal 255 karakter.',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }

        Speaker::create($validated);

        return redirect()->route('admin.speaker.index')->with('success', 'Data pemateri berhasil ditambahkan.');
    }

    public function show(Speaker $speaker)
    {
        return view('admin.speaker.show', compact('speaker'));
    }

    public function edit(Speaker $speaker)
    {
        return view('admin.speaker.edit', compact('speaker'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.mimes' => 'Format foto harus berupa: jpeg, png, jpg, atau gif.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal adalah 2MB.',
            'name.required' => 'Nama pemateri wajib diisi.',
            'name.max' => 'Nama pemateri maksimal 255 karakter.',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
                Storage::disk('public')->delete($speaker->photo);
            }
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }

        $speaker->update($validated);

        return redirect()->route('admin.speaker.index')->with('success', 'Data pemateri berhasil diperbarui.');
    }

    public function destroy(Speaker $speaker)
    {
        // Hapus foto dari storage
        if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
            Storage::disk('public')->delete($speaker->photo);
        }

        $speaker->delete();
        return redirect()->route('admin.speaker.index')->with('success', 'Data pemateri berhasil dihapus.');
    }
}
