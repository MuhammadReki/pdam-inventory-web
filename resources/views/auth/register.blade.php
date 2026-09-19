<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('auth.register') }} - PDAM Inventory</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url('{{ asset("assets/images/BackgroundPDAM-ASLI.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 38px 40px 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s ease;
        }

        .register-card:hover { transform: translateY(-4px); }

        .register-logo { text-align: center; margin-bottom: 22px; }

        /* ❌ BACKGROUND BIRU DIHAPUS, LANGSUNG LOGO */
        .register-logo img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            display: block;
            margin: 0 auto 8px;
        }

        .register-logo h3 {
            font-weight: 700;
            color: #0d47a1;
            font-size: 1.55rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .register-logo p { color: #6c7a8a; font-size: 0.85rem; margin: 2px 0 0; font-weight: 400; }

        .register-divider {
            height: 3px;
            width: 50px;
            background: linear-gradient(90deg, #0d47a1, #64b5f6);
            margin: 15px auto 22px;
            border-radius: 10px;
        }

        .register-card .form-label { font-weight: 500; color: #1a2332; font-size: 0.85rem; margin-bottom: 5px; }
        .register-card .form-label i { color: #0d47a1; margin-right: 6px; }

        .register-card .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #e8edf3;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            background: #fafbfc;
        }

        .register-card .form-control:focus {
            border-color: #0d47a1;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.08);
        }

        .register-card .form-control::placeholder { color: #b0bec5; font-size: 0.82rem; }

        .password-info { color: #90a4ae; font-size: 0.72rem; margin-top: 5px; }
        .password-info i { color: #0d47a1; margin-right: 3px; }

        .register-card .btn-register {
            background: linear-gradient(135deg, #0d47a1, #1565c0);
            border: none;
            color: white;
            font-weight: 600;
            padding: 13px;
            border-radius: 12px;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 0.8px;
            margin-top: 5px;
        }

        .register-card .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(13, 71, 161, 0.35);
            background: linear-gradient(135deg, #0a3d8a, #0d47a1);
        }

        .register-card .btn-register:active { transform: translateY(0); }
        .register-card .btn-register i { margin-right: 7px; }

        .alert-custom {
            border-radius: 12px;
            border: none;
            font-weight: 500;
            padding: 11px 15px;
            margin-bottom: 18px;
            font-size: 0.85rem;
        }

        .alert-custom i { margin-right: 7px; }

        .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 0.85rem;
            color: #6c7a8a;
            border-top: 1px solid #e8edf3;
            padding-top: 18px;
        }

        .login-link a {
            color: #0d47a1;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .login-link a:hover { text-decoration: underline; color: #1565c0; }

        .register-footer {
            text-align: center;
            margin-top: 22px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.78rem;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .register-footer span { font-weight: 600; color: #ffffff; }
        .register-footer .separator { margin: 0 6px; color: rgba(255, 255, 255, 0.4); }

        @media (max-width: 480px) {
            body { padding: 15px; }
            .register-card { padding: 30px 20px 25px; border-radius: 20px; }
            .register-logo h3 { font-size: 1.3rem; }
            .register-logo img { width: 85px; height: 85px; }
            .register-footer { margin-top: 18px; font-size: 0.7rem; }
        }
    </style>
</head>

<body>

    <div class="register-card">

        <div class="register-logo">
            <img src="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}" alt="Logo PDAM">
            <h3>PDAM Inventory</h3>
            <p>{{ __('auth.system_inventory') }}</p>
            <div class="register-divider"></div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-person"></i>
                    {{ __('auth.full_name') }}
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('auth.name_placeholder') }}"
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i>
                    {{ __('auth.email') }}
                </label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="{{ __('auth.email_placeholder') }}"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i>
                    {{ __('auth.password') }}
                </label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('auth.password_placeholder') }}"
                >
                <div class="password-info">
                    <i class="bi bi-info-circle"></i>
                    {{ __('auth.password_info') }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-shield-check"></i>
                    {{ __('auth.confirm_password') }}
                </label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('auth.confirm_password_placeholder') }}"
                >
            </div>

            <button type="submit" class="btn btn-register">
                <i class="bi bi-person-plus-fill"></i>
                {{ strtoupper(__('auth.register_now')) }}
            </button>

            <div class="login-link">
                {{ __('auth.have_account') }}
                <a href="{{ route('login') }}">
                    {{ __('auth.login_now') }}
                </a>
            </div>

        </form>

    </div>

    <div class="register-footer">
        &copy; 2026
        <span>PDAM Kota Payakumbuh</span>
        <span class="separator">•</span>
        {{ __('auth.system_inventory') }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>