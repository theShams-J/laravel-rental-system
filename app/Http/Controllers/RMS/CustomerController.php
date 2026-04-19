<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('pages.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'mobile' => 'required|string|max:45',
            'email'  => 'nullable|email|max:100',
        ]);

        Customer::create([
            'company_id' => Auth::user()->company_id,
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'address'    => $request->address,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'mobile' => 'required|string|max:45',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update([
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'address'    => $request->address,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.delete', compact('customer'));
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
