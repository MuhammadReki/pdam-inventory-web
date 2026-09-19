<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.login') }} - PDAM Inventory</title>
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

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 45px 40px 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-4px);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        /* ❌ BACKGROUND BIRU DIHAPUS, LANGSUNG LOGO */
        .login-logo img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            display: block;
            margin: 0 auto 8px;
        }

        .login-logo h3 {
            font-weight: 700;
            color: #0d47a1;
            font-size: 1.6rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .login-logo p {
            color: #6c7a8a;
            font-size: 0.9rem;
            margin: 2px 0 0;
            font-weight: 400;
        }

        .login-divider {
            height: 3px;
            width: 50px;
            background: linear-gradient(90deg, #0d47a1, #64b5f6);
            margin: 0 auto 25px;
            border-radius: 10px;
        }

        .login-card .form-label {
            font-weight: 500;
            color: #1a2332;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .login-card .form-label i {
            color: #0d47a1;
            margin-right: 6px;
        }

        .login-card .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #e8edf3;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: #fafbfc;
        }

        .login-card .form-control:focus {
            border-color: #0d47a1;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.08);
        }

        .login-card .form-control::placeholder {
            color: #b0bec5;
            font-size: 0.85rem;
        }

        .login-card .btn-login {
            background: linear-gradient(135deg, #0d47a1, #1565c0);
            border: none;
            color: white;
            font-weight: 600;
            padding: 13px;
            border-radius: 12px;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(13, 71, 161, 0.35);
            background: linear-gradient(135deg, #0a3d8a, #0d47a1);
        }

        .login-card .btn-login i {
            margin-right: 8px;
        }

        .login-card .form-check-label {
            font-size: 0.85rem;
            color: #546e7a;
            cursor: pointer;
        }

        .login-card .form-check-input {
            border-radius: 4px;
            border: 2px solid #cfd8dc;
            cursor: pointer;
        }

        .login-card .form-check-input:checked {
            background-color: #0d47a1;
            border-color: #0d47a1;
        }

        .login-card .forgot-link {
            font-size: 0.85rem;
            color: #0d47a1;
            text-decoration: none;
            font-weight: 500;
        }

        .login-card .forgot-link:hover {
            text-decoration: underline;
        }

        .login-card .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c7a8a;
            border-top: 1px solid #e8edf3;
            padding-top: 20px;
        }

        .login-card .register-link a {
            color: #0d47a1;
            font-weight: 600;
            text-decoration: none;
        }

        .login-card .register-link a:hover {
            text-decoration: underline;
        }

        .sso-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 0.8rem;
            color: #0d47a1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sso-info i {
            font-size: 1rem;
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            font-weight: 500;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-custom i {
            margin-right: 8px;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.8rem;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .login-footer span {
            font-weight: 600;
            color: #ffffff;
        }

        .login-footer .separator {
            margin: 0 6px;
            color: rgba(255, 255, 255, 0.4);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px 25px;
            }
            .login-logo h3 {
                font-size: 1.3rem;
            }
            .login-logo img {
                width: 90px;
                height: 90px;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">

        <div class="login-logo">
            <img src="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}" alt="Logo PDAM">
            <h3>PDAM Inventory</h3>
            <p>{{ __('auth.system_inventory') }}</p>
            <div class="login-divider"></div>
        </div>

        @if(request('redirect') === 'sso')
            <div class="sso-info">
                <i class="bi bi-info-circle-fill"></i>
                <span>{!! __('auth.sso_login_info') !!}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(request('redirect') === 'sso')
                <input type="hidden" name="redirect" value="sso">
            @endif

            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope"></i> {{ __('auth.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('auth.email_placeholder') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="bi bi-lock"></i> {{ __('auth.password') }}</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="{{ __('auth.password_placeholder') }}">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">{{ __('auth.remember_me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                @endif
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right"></i> {{ strtoupper(__('auth.login')) }}
            </button>

            <div class="register-link">
                {{ __('auth.no_account') }} <a href="{{ route('register') }}">{{ __('auth.register_now') }}</a>
            </div>

        </form>
    </div>

    <div class="login-footer">
        &copy; 2026 <span>PDAM Kota Payakumbuh</span>
        <span class="separator">•</span> {{ __('auth.system_inventory') }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>