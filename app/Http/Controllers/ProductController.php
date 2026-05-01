<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::with('user', 'category')->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('manage-product');

        $users      = User::all();
        $categories = Category::all();
        return view('product.create', compact('users', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Produk berhasil ditambahkan.');

        } catch (QueryException $e) {
            Log::error('Product store database error', ['message' => $e->getMessage()]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database saat menyimpan produk.');

        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', ['message' => $e->getMessage()]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan yang tidak terduga.');
        }
    }

    public function show(Product $product)
    {
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $users      = User::all();
        $categories = Category::all();
        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();
        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}