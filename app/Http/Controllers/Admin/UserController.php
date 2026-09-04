<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = \App\Models\User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.user.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,organizer,admin'
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        if ($user->role === 'organizer') {
            $user->organizer()->create([
                'name' => $user->name,
                'is_verified' => true
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,organizer,admin'
        ]);
        
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if (!empty($validated['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);
        
        if ($validated['role'] === 'organizer' && !$user->organizer) {
            $user->organizer()->create([
                'name' => $user->name,
                'is_verified' => true
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(\App\Models\User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        
        return redirect()->route('admin.user.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
