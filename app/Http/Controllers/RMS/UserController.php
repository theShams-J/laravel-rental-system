<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\RMS\User;
use App\Models\RMS\Role;

class UserController extends Controller
{
    public function index()
    {
        // Admin sees only users from their own company (CompanyScope handles this)
        $users = User::with(['role', 'company'])
    ->where('company_id', Auth::user()->company_id)
    ->where('role_id', '!=', 1)
    ->latest()
    ->paginate(10);

        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'super_admin')->get();
        return view('pages.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:rms_users,email',
            'password' => 'required|min:8|confirmed',
            'role_id'  => 'required|exists:rms_roles,id',
            'contact'  => 'nullable|string|max:45',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'company_id' => Auth::user()->company_id,
            'role_id'    => $request->role_id,
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

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['role', 'company']);
        return view('pages.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'super_admin')->get();
        return view('pages.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:rms_users,email,' . $user->id,
            'role_id'  => 'required|exists:rms_roles,id',
            'contact'  => 'nullable|string|max:45',
            'password' => 'nullable|min:8|confirmed',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'role_id'    => $request->role_id,
            'contact'    => $request->contact,
            'is_active'  => $request->is_active ?? 1,
            'updated_by' => Auth::id(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
