<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('tickets')->latest()->get();

        return view('superadmin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori tiket berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->tickets()->count() > 0) {
            return redirect()->route('superadmin.categories.index')
                ->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan pada tiket.');
        }

        $category->delete();

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori tiket berhasil dihapus.');
    }
}
