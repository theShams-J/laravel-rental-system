<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('pages.inventory.product.index', compact('products'));
    }

    public function create()
    {
        return view('pages.inventory.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'price' => 'nullable|numeric',
        ]);

        Product::create([
            'company_id'  => Auth::user()->company_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.inventory.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.inventory.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'price' => 'nullable|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'updated_by'  => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.inventory.product.delete', compact('product'));
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
