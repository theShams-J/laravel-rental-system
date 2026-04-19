<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RMS\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        $superAdmins = User::with('role')
            ->where('role_id', 1) // super_admin role
            ->latest()
            ->paginate(15);

        return view('super.superadmins.index', compact('superAdmins'));
    }

    public function create()
    {
        return view('super.superadmins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:rms_users,email',
            'password' => 'required|min:8|confirmed',
            'contact'  => 'nullable|string|max:45',
            'photo'    => 'nullable|image|max:2048',
        ]);

        $data = [
            'company_id' => null, // super admin has no company
            'role_id'    => 1,    // super_admin
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

        return redirect()->route('super.superadmins.index')
            ->with('success', 'Super Admin created successfully.');
    }

    public function show(User $superadmin)
    {
        return view('super.superadmins.show', compact('superadmin'));
    }

    public function edit(User $superadmin)
    {
        return view('super.superadmins.edit', compact('superadmin'));
    }

    public function update(Request $request, User $superadmin)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:rms_users,email,' . $superadmin->id,
            'contact'  => 'nullable|string|max:45',
            'password' => 'nullable|min:8|confirmed',
            'is_active'=> 'required|in:0,1',
            'photo'    => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'contact'    => $request->contact,
            'is_active'  => $request->is_active,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $superadmin->update($data);

        return redirect()->route('super.superadmins.index')
            ->with('success', 'Super Admin updated successfully.');
    }

    public function destroy(User $superadmin)
    {
        // Prevent self-deletion
        if ($superadmin->id === Auth::id()) {
            return redirect()->route('super.superadmins.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $superadmin->delete();

        return redirect()->route('super.superadmins.index')
            ->with('success', 'Super Admin deleted.');
    }

    public function delete($id)
    {
        $superadmin = User::findOrFail($id);
        return view('super.superadmins.delete', compact('superadmin'));
    }

    public function toggleActive(User $superadmin)
    {
        if ($superadmin->id === Auth::id()) {
            return redirect()->route('super.superadmins.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $superadmin->update(['is_active' => !$superadmin->is_active]);
        $status = $superadmin->is_active ? 'activated' : 'deactivated';

        return redirect()->route('super.superadmins.index')
            ->with('success', "Super Admin {$status} successfully.");
    }
}