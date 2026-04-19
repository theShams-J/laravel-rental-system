<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RMS\Company;
use App\Models\RMS\User;
use App\Models\RMS\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::with(['company', 'role'])
            ->where('role_id', 2)
            ->latest()
            ->paginate(15);

        return view('super.admins.index', compact('admins'));
    }

    public function create()
    {
        $companies = Company::where('is_active', 1)->orderBy('name')->get();
        return view('super.admins.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:rms_users,email',
            'password'   => 'required|min:8|confirmed',
            'company_id' => 'required|exists:rms_companies,id',
            'contact'    => 'nullable|string|max:45',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $data = [
            'company_id' => $request->company_id,
            'role_id'    => 2, // admin
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'contact'    => $request->contact,
            'is_active'  => 1,
            'created_by' => Auth::id(),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        User::create($data);

        return redirect()->route('super.admins.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function show(User $admin)
    {
        return view('super.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        $companies = Company::where('is_active', 1)->orderBy('name')->get();
        return view('super.admins.edit', compact('admin', 'companies'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:rms_users,email,' . $admin->id,
            'company_id' => 'required|exists:rms_companies,id',
            'contact'    => 'nullable|string|max:45',
            'password'   => 'nullable|min:8|confirmed',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'company_id' => $request->company_id,
            'contact'    => $request->contact,
            'updated_by' => Auth::id(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $admin->update($data);

        return redirect()->route('super.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('super.admins.index')
            ->with('success', 'Admin deleted.');
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        return view('super.admins.delete', compact('admin'));
    }

    public function toggleActive(User $admin)
    {
        $admin->update(['is_active' => !$admin->is_active]);
        $status = $admin->is_active ? 'activated' : 'deactivated';
        return redirect()->route('super.admins.index')
            ->with('success', "Admin {$status} successfully.");
    }
}
