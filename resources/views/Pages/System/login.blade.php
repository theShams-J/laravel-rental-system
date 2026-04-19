<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shams Rental | Comfort · Elegance · Luxury</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold: #b8972a;
            --gold-light: #d4af57;
            --gold-pale: #f5edd8;
            --dark: #1a1a18;
            --mid: #3a3830;
            --cream: #faf8f3;
            --white: #ffffff;
            --green: #2a5c3f;
            --green-dark: #1e4430;
            --green-light: #3a7d58;
            --border: rgba(184,151,42,0.25);
        }

        html, body {
            height: 100%;
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ── NOISE TEXTURE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ── NAVBAR ── */
        .top-nav {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 68px;
            background: rgba(250,248,243,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .nav-container {
            width: 100%;
            padding: 0 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 4px;
            color: var(--dark);
            text-transform: uppercase;
        }

        .brand-name span {
            color: var(--gold);
        }

        .btn-login {
            background: transparent;
            color: var(--green);
            padding: 9px 28px;
            border: 1.5px solid var(--green);
            border-radius: 2px;
            text-decoration: none;
            font-family: 'Jost', sans-serif;
            font-weight: 500;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-login:hover {
            background: var(--green);
            color: var(--white);
        }

        /* ── HERO / WELCOME ── */
        .welcome-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 68px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Decorative corner lines */
        .corner-deco {
            position: fixed;
            width: 80px;
            height: 80px;
            pointer-events: none;
            z-index: 2;
        }
        .corner-deco.tl { top: 80px; left: 24px; border-top: 1px solid var(--border); border-left: 1px solid var(--border); }
        .corner-deco.tr { top: 80px; right: 24px; border-top: 1px solid var(--border); border-right: 1px solid var(--border); }
        .corner-deco.bl { bottom: 24px; left: 24px; border-bottom: 1px solid var(--border); border-left: 1px solid var(--border); }
        .corner-deco.br { bottom: 24px; right: 24px; border-bottom: 1px solid var(--border); border-right: 1px solid var(--border); }

        .content-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeUp 1.2s ease forwards;
            opacity: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .top-image {
            width: 220px;
            max-width: 80%;
            height: auto;
            margin-bottom: 36px;
            opacity: 0.88;
            filter: drop-shadow(0 8px 32px rgba(184,151,42,0.18));
        }

        .welcome-tagline {
            font-family: 'Jost', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 18px;
        }

        .welcome-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5vw, 64px);
            font-weight: 300;
            color: var(--dark);
            letter-spacing: 3px;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .welcome-text strong {
            font-weight: 700;
            color: var(--green);
        }

        .divider-ornament {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 28px 0;
            color: var(--gold);
        }

        .divider-ornament::before,
        .divider-ornament::after {
            content: '';
            display: block;
            width: 80px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }

        .divider-ornament::after {
            background: linear-gradient(to left, transparent, var(--gold));
        }

        .welcome-sub {
            font-size: 14px;
            font-weight: 300;
            color: var(--mid);
            letter-spacing: 1px;
            max-width: 360px;
            line-height: 1.8;
        }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26,26,24,0.65);
            backdrop-filter: blur(6px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
            animation: overlayIn 0.3s ease forwards;
        }

        @keyframes overlayIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        .modal-card {
            background: var(--white);
            width: 100%;
            max-width: 420px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
            animation: cardIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-top-bar {
            background: var(--green);
            padding: 28px 32px 24px;
            text-align: center;
            position: relative;
        }

        .modal-top-bar .modal-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 4px;
            color: var(--white);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .modal-top-bar .modal-subtitle {
            font-size: 11px;
            letter-spacing: 3px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
        }

        .modal-close {
            position: absolute;
            top: 14px; right: 16px;
            background: none;
            border: none;
            color: rgba(255,255,255,0.6);
            font-size: 22px;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s;
        }
        .modal-close:hover { color: var(--white); }

        .modal-body {
            padding: 32px;
        }

        /* Type toggle */
        .type-toggle {
            display: flex;
            background: #f4f4f0;
            border-radius: 3px;
            padding: 4px;
            margin-bottom: 28px;
        }

        .type-toggle label {
            flex: 1;
            text-align: center;
            padding: 9px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #999;
            cursor: pointer;
            border-radius: 2px;
            transition: all 0.25s;
        }

        .type-toggle input[type="radio"] { display: none; }

        .type-toggle input[type="radio"]:checked + label {
            background: var(--green);
            color: var(--white);
            box-shadow: 0 2px 8px rgba(42,92,63,0.3);
        }

        /* Form fields */
        .form-field {
            margin-bottom: 20px;
        }

        .form-field label {
            display: block;
            margin-bottom: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #888;
        }

        .form-field input {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #e8e8e4;
            border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 14px;
            color: var(--dark);
            background: #fdfdfb;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-field input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(42,92,63,0.08);
        }

        .error-msg {
            background: #fff5f5;
            border-left: 3px solid #e53e3e;
            padding: 10px 14px;
            border-radius: 2px;
            font-size: 13px;
            color: #c53030;
            margin-bottom: 20px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--green);
            border: none;
            border-radius: 3px;
            color: var(--white);
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s, transform 0.15s;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .nav-container { padding: 0 20px; }
            .brand-name { font-size: 17px; letter-spacing: 2px; }
            .modal-body { padding: 24px 20px; }
            .corner-deco { display: none; }
        }
    </style>
</head>
<body>

    {{-- Decorative corners --}}
    <div class="corner-deco tl"></div>
    <div class="corner-deco tr"></div>
    <div class="corner-deco bl"></div>
    <div class="corner-deco br"></div>

    {{-- ── NAVBAR ── --}}
    <nav class="top-nav">
        <div class="nav-container">
            <div class="brand-name">Shams <span>Rental</span></div>
            <button class="btn-login" onclick="openModal()">Login</button>
        </div>
    </nav>

    {{-- ── HERO ── --}}
    <div class="welcome-wrapper">
        <div class="content-box">
            <p class="welcome-tagline">Premium Property Management</p>
            <img src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}"
                 class="top-image"
                 alt="Shams Rental">
            <h1 class="welcome-text">
                Comfort · Elegance<br><strong>· Luxury</strong>
            </h1>
            <div class="divider-ornament">✦</div>
            <p class="welcome-sub">Exceptional living spaces managed with care,<br>precision, and elegance.</p>
        </div>
    </div>

    {{-- ── LOGIN MODAL ── --}}
    <div class="modal-overlay" id="loginModal" onclick="handleOverlayClick(event)">
        <div class="modal-card">

            <div class="modal-top-bar">
                <button class="modal-close" onclick="closeModal()">✕</button>
                <div class="modal-logo">Shams Rental</div>
                <div class="modal-subtitle">Secure Access Portal</div>
            </div>

            <div class="modal-body">

                @if ($errors->any())
                    <div class="error-msg">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ url('login') }}">
                    @csrf

                    {{-- Type Toggle --}}
                    <div class="type-toggle">
                        <input type="radio" name="login_type" id="type-admin" value="admin" checked onchange="toggleFields('admin')">
                        <label for="type-admin">Admin</label>
                        <input type="radio" name="login_type" id="type-tenant" value="tenant" onchange="toggleFields('tenant')">
                        <label for="type-tenant">Tenant</label>
                    </div>

                    <div class="form-field">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                               placeholder="you@example.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-field">
                        <label id="field-label" for="credential-input">Password</label>
                        <input type="password" id="credential-input" name="password"
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('loginModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('loginModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('loginModal')) closeModal();
        }

        function toggleFields(type) {
            const input = document.getElementById('credential-input');
            const label = document.getElementById('field-label');
            if (type === 'tenant') {
                label.innerText = 'Mobile Number';
                input.name = 'mobile';
                input.type = 'text';
                input.placeholder = '01XXXXXXXXX';
            } else {
                label.innerText = 'Password';
                input.name = 'password';
                input.type = 'password';
                input.placeholder = '••••••••';
            }
        }

        // Auto-open if validation errors exist
        @if ($errors->any())
            window.addEventListener('DOMContentLoaded', openModal);
        @endif

        // Close on Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</body>
</html>