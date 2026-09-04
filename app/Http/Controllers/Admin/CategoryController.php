<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = \App\Models\Category::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.category.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        \App\Models\Category::create($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, \App\Models\Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(\App\Models\Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
