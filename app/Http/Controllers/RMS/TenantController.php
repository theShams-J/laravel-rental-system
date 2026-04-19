<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Tenant;
use App\Models\RMS\Country;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('country')->latest()->paginate(10);
        return view('pages.tenant.index', compact('tenants'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.tenant.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                        => 'required|string|max:100',
            'nid'                         => 'required|string|max:45',
            'contact'                     => 'required|string|max:45',
            'email'                       => 'required|email|max:100',
            'gender'                      => 'nullable|in:Male,Female,Other',
            'date_of_birth'               => 'nullable|date',
            'profession'                  => 'nullable|string|max:100',
            'address'                     => 'nullable|string',
            'city'                        => 'nullable|string|max:45',
            'postcode'                    => 'nullable|string|max:45',
            'country_id'                  => 'nullable|exists:rms_countries,id',
            'emergency_contact_name'      => 'nullable|string|max:100',
            'emergency_contact_mobile'    => 'nullable|string|max:45',
            'emergency_contact_relation'  => 'nullable|string|max:50',
            'remarks'                     => 'nullable|string',
            'photo'                       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nid_front'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nid_back'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant = Tenant::create([
            'company_id'                  => Auth::user()->company_id,
            'name'                        => $request->name,
            'nid'                         => $request->nid,
            'contact'                     => $request->contact,
            'email'                       => $request->email,
            'gender'                      => $request->gender,
            'date_of_birth'               => $request->date_of_birth,
            'profession'                  => $request->profession,
            'address'                     => $request->address,
            'city'                        => $request->city,
            'postcode'                    => $request->postcode,
            'country_id'                  => $request->country_id,
            'emergency_contact_name'      => $request->emergency_contact_name,
            'emergency_contact_mobile'    => $request->emergency_contact_mobile,
            'emergency_contact_relation'  => $request->emergency_contact_relation,
            'remarks'                     => $request->remarks,
            'is_active'                   => 1,
            'created_by'                  => Auth::id(),
        ]);

        // Handle photo, nid_front, nid_back uploads
        foreach (['photo', 'nid_front', 'nid_back'] as $field) {
            if ($request->hasFile($field)) {
                $imageName = $tenant->id . '_' . $field . '.' . $request->file($field)->extension();
                $request->file($field)->move(public_path('img/tenants'), $imageName);
                $tenant->update([$field => $imageName]);
            }
        }

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    public function show($id)
    {
        $tenant = Tenant::with(['activeLease.apartment.building', 'invoices', 'receipts'])->findOrFail($id);
        return view('pages.tenant.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $countries = Country::all();
        return view('pages.tenant.edit', compact('tenant', 'countries'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name'                        => 'required|string|max:100',
            'nid'                         => 'required|string|max:45',
            'contact'                     => 'required|string|max:45',
            'email'                       => 'required|email|max:100',
            'gender'                      => 'nullable|in:Male,Female,Other',
            'date_of_birth'               => 'nullable|date',
            'profession'                  => 'nullable|string|max:100',
            'address'                     => 'nullable|string',
            'city'                        => 'nullable|string|max:45',
            'postcode'                    => 'nullable|string|max:45',
            'country_id'                  => 'nullable|exists:rms_countries,id',
            'emergency_contact_name'      => 'nullable|string|max:100',
            'emergency_contact_mobile'    => 'nullable|string|max:45',
            'emergency_contact_relation'  => 'nullable|string|max:50',
            'remarks'                     => 'nullable|string',
            'photo'                       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nid_front'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nid_back'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant->update([
            'name'                        => $request->name,
            'nid'                         => $request->nid,
            'contact'                     => $request->contact,
            'email'                       => $request->email,
            'gender'                      => $request->gender,
            'date_of_birth'               => $request->date_of_birth,
            'profession'                  => $request->profession,
            'address'                     => $request->address,
            'city'                        => $request->city,
            'postcode'                    => $request->postcode,
            'country_id'                  => $request->country_id,
            'emergency_contact_name'      => $request->emergency_contact_name,
            'emergency_contact_mobile'    => $request->emergency_contact_mobile,
            'emergency_contact_relation'  => $request->emergency_contact_relation,
            'remarks'                     => $request->remarks,
            'is_active'                   => $request->is_active ?? 1,
            'updated_by'                  => Auth::id(),
        ]);

        // Handle photo, nid_front, nid_back uploads
        foreach (['photo', 'nid_front', 'nid_back'] as $field) {
            if ($request->hasFile($field)) {
                $imageName = $tenant->id . '_' . $field . '.' . $request->file($field)->extension();
                $request->file($field)->move(public_path('img/tenants'), $imageName);
                $tenant->update([$field => $imageName]);
            }
        }

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function delete($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('pages.tenant.delete', compact('tenant'));
    }

    public function destroy(Tenant $tenant)
    {
        try {
            $tenant->delete();
            return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'Cannot delete tenant. They have active leases or payment history.');
            }
            throw $e;
        }
    }
}