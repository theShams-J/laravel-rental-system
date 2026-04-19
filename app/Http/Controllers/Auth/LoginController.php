<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RMS\User;
use App\Models\RMS\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.system.login');
    }

    private function clearPreviousSession(Request $request): void
    {
        if (Auth::check()) Auth::logout();
        $request->session()->forget(['tenant_id', 'is_tenant']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function login(Request $request)
    {
        $email = trim($request->email);
        $type  = strtolower($request->login_type ?? 'admin');

        $this->clearPreviousSession($request);

        if ($type === 'tenant') {
            $tenant = Tenant::where('email', $email)
                            ->where('contact', trim($request->mobile))
                            ->where('is_active', 1)
                            ->first();

            if ($tenant) {
                session(['tenant_id' => $tenant->id, 'company_id' => $tenant->company_id, 'is_tenant' => true]);
                return redirect()->route('tenant.dashboard');
            }

            return back()->withErrors(['email' => 'Invalid tenant credentials.'])->withInput();
        }

        $user = User::with('role')->where('email', $email)->where('is_active', 1)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        return $user->isSuperAdmin()
            ? redirect()->route('super.dashboard')
            : redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget(['tenant_id', 'company_id', 'is_tenant']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}