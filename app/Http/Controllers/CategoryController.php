<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('manage-category');

        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('manage-category');

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage-category');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama category wajib diisi.',
            'name.unique'   => 'Nama category sudah ada.',
            'name.max'      => 'Nama category maksimal 255 karakter.',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $this->authorize('manage-category');

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('manage-category');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama category wajib diisi.',
            'name.unique'   => 'Nama category sudah ada.',
            'name.max'      => 'Nama category maksimal 255 karakter.',
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('manage-category');    

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil dihapus.');
    }
}
