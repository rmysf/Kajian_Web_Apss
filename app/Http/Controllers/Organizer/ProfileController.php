<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $organizer = Auth::user()->organizer;
        return view('organizer.profile.edit', compact('organizer'));
    }

    public function update(Request $request)
    {
        $organizer = Auth::user()->organizer;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($organizer->logo && Storage::disk('public')->exists($organizer->logo)) {
                Storage::disk('public')->delete($organizer->logo);
            }
            $path = $request->file('logo')->store('organizers', 'public');
            $validated['logo'] = $path;
        }

        $organizer->update($validated);

        return redirect()->route('organizer.profile.edit')->with('success', 'Profil penyelenggara berhasil diperbarui.');
    }
}
