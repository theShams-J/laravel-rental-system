<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RMS\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount([
            'users as admins_count' => fn($q) => $q->where('role_id', 2),
        ])->latest()->paginate(15);

        return view('super.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('super.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'nullable|email|max:100',
            'contact'        => 'nullable|string|max:45',
            'city'           => 'nullable|string|max:45',
            'area'           => 'nullable|string|max:45',
            'street_address' => 'nullable|string|max:100',
            'post_code'      => 'nullable|string|max:20',
            'website'        => 'nullable|string|max:100',
            'bin'            => 'nullable|string|max:45',
            'trade_license'  => 'nullable|string|max:100',
            'tagline'        => 'nullable|string|max:150',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('logo');
        $data['is_active'] = 1;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Company::create($data);

        return redirect()->route('super.companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('super.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:100',
            'contact' => 'nullable|string|max:45',
            'logo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($data);

        return redirect()->route('super.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('super.companies.index')
            ->with('success', 'Company deleted.');
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        return view('super.companies.delete', compact('company'));
    }

    public function toggleActive(Company $company)
    {
        $company->update(['is_active' => !$company->is_active]);
        $status = $company->is_active ? 'activated' : 'deactivated';
        return redirect()->route('super.companies.index')
            ->with('success', "Company {$status} successfully.");
    }
    public function show(Company $company)
{
    // Load the company with any relations if needed
    return view('super.companies.show', compact('company'));
}
}
