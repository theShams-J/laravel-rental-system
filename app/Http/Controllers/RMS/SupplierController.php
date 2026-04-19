<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('pages.purchase.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('pages.purchase.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'mobile' => 'required|string|max:45',
            'email'  => 'nullable|email|max:100',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $supplier = Supplier::create([
            'company_id' => Auth::user()->company_id,
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'address'    => $request->address,
            'created_by' => Auth::id(),
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $supplier->id . '.' . $request->photo->extension();
            $supplier->update(['photo' => $imageName]);
            $request->photo->move(public_path('img/suppliers'), $imageName);
        }

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('pages.purchase.supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('pages.purchase.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'mobile' => 'required|string|max:45',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $supplier->update([
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'address'    => $request->address,
            'updated_by' => Auth::id(),
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $supplier->id . '.' . $request->photo->extension();
            $supplier->update(['photo' => $imageName]);
            $request->photo->move(public_path('img/suppliers'), $imageName);
        }

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('pages.purchase.supplier.delete', compact('supplier'));
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
