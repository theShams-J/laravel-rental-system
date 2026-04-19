@extends('layouts.master')
@section('page')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');
    :root {
        --emerald: #1a6b4a; --emerald-pale: #edf7f2;
        --rose: #c0392b; --rose-pale: #fdf0ee;
        --ink: #16191f; --ink-soft: #4a5160; --ink-muted: #8c93a3;
        --surface: #f7f8fa; --white: #ffffff; --border: #e8eaef;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06); --radius: 10px;
    }
    
    /* Dark mode overrides */
    .dark {
        --emerald: #2d8a63; --emerald-pale: #1a3a2e;
        --rose: #e74c3c; --rose-pale: #4a1a15;
        --ink: #e8eaed; --ink-soft: #b0b3b8; --ink-muted: #8c9196;
        --surface: #1a1d20; --white: #2a2e32; --border: #3a3f44;
    }
    
    .rms-wrap { font-family: 'DM Sans', sans-serif; padding: 28px 24px 48px; background: var(--surface); min-height: 100vh; }
    .rms-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid var(--border); }
    .rms-label { font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: var(--emerald); margin-bottom: 6px; }
    .rms-header h1 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: var(--ink); margin: 0; }
    .btn-rms-back { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: var(--white); border: 1.5px solid var(--border); border-radius: 6px; font-size: 13px; font-weight: 500; color: var(--ink-soft); text-decoration: none; transition: all 0.2s; }
    .btn-rms-back:hover { border-color: var(--emerald); color: var(--emerald); background: var(--emerald-pale); }

    .rms-form-card { background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; max-width: 100%; }
    .rms-form-head { padding: 18px 24px; border-bottom: 1px solid var(--border); background: #fcfcfd; }
    .rms-form-head h6 { font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); margin: 0; }
    .rms-form-body { padding: 28px 24px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }
    .form-row.single { grid-template-columns: 1fr; }
    @media(max-width:600px) { .form-row { grid-template-columns: 1fr; } }

    .form-group { display: flex; flex-direction: column; }
    .form-group label { font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 7px; }
    .form-group input, .form-group select {
        padding: 11px 14px; border: 1.5px solid var(--border); border-radius: 6px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--ink);
        background: #fdfdfb; transition: border-color 0.2s, box-shadow 0.2s; outline: none;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: var(--emerald); box-shadow: 0 0 0 3px rgba(26,107,74,0.08);
    }
    .form-group .hint { font-size: 11px; color: var(--ink-muted); margin-top: 5px; }

    .form-divider { border: none; border-top: 1px solid var(--border); margin: 24px 0; }

    .rms-alert-error { background: var(--rose-pale); border-left: 4px solid var(--rose); color: var(--rose); padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }

    .btn-submit { display: inline-flex; align-items: center; gap: 7px; padding: 12px 28px; background: var(--emerald); color: var(--white); border: none; border-radius: 6px; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.2s; }
    .btn-submit:hover { background: #155a3d; }
    
    /* Dark mode specific adjustments */
    .dark .rms-form-head { background: var(--white); }
    .dark .form-group input, .dark .form-group select { background: var(--white); }
</style>

<div class="rms-wrap">

    <div class="rms-header">
        <div>
            <div class="rms-label">Super Admin · Admin Users</div>
            <h1>Edit Admin User</h1>
        </div>
        <a href="{{ route('super.admins.index') }}" class="btn-rms-back">
            <span class="fas fa-arrow-left"></span> Back to List
        </a>
    </div>

    <div class="rms-form-card">
        <div class="rms-form-head">
            <h6>Admin Details</h6>
        </div>
        <div class="rms-form-body">

            @if($errors->any())
                <div class="rms-alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('super.admins.update', $admin->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row single">
                    <div class="form-group">
                        <label>Assign to Company <span style="color:var(--rose);">*</span></label>
                        <select name="company_id" required>
                            <option value="">— Select Company —</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id', $admin->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name <span style="color:var(--rose);">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" value="{{ old('contact', $admin->contact) }}" placeholder="01XXXXXXXXX">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Profile Photo</label>
                        @if($admin->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $admin->photo) }}" alt="{{ $admin->name }}" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="photo" accept="image/*">
                        <div class="hint">Upload a new photo to replace the current one.</div>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label>Email Address <span style="color:var(--rose);">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required placeholder="admin@company.com">
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-row">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat password">
                    </div>
                </div>

                <div style="margin-top: 8px;">
                    <button type="submit" class="btn-submit">
                        <span class="fas fa-save"></span> Save Admin
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection