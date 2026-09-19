<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.reset_password') }} - PDAM Inventory</title>
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

        .login-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: #ffffff;
            border-radius: 24px;
            padding: 45px 40px 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s ease;
        }

        .login-card:hover { transform: translateY(-4px); }

        .login-logo { text-align: center; margin-bottom: 28px; }

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

        .login-logo p { color: #6c7a8a; font-size: 0.9rem; margin: 2px 0 0; font-weight: 400; }

        .login-divider {
            height: 3px;
            width: 50px;
            background: linear-gradient(90deg, #0d47a1, #64b5f6);
            margin: 0 auto 25px;
            border-radius: 10px;
        }

        .info-text {
            color: #6c7a8a;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .info-text i { color: #0d47a1; margin-right: 6px; }

        .login-card .form-label { font-weight: 500; color: #1a2332; font-size: 0.85rem; margin-bottom: 5px; }
        .login-card .form-label i { color: #0d47a1; margin-right: 6px; }

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

        .login-card .form-control::placeholder { color: #b0bec5; font-size: 0.85rem; }

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

        .login-card .btn-login i { margin-right: 8px; }

        .login-card .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c7a8a;
            border-top: 1px solid #e8edf3;
            padding-top: 20px;
        }

        .login-card .back-link a { color: #0d47a1; font-weight: 600; text-decoration: none; }
        .login-card .back-link a:hover { text-decoration: underline; }

        .alert-custom {
            border-radius: 12px;
            border: none;
            font-weight: 500;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-custom i { margin-right: 8px; }

        .alert-custom.alert-success { background: #e8f5e9; color: #2e7d32; }
        .alert-custom.alert-danger { background: #fbe9e7; color: #c62828; }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.8rem;
            font-weight: 300;
            letter-spacing: 0.3px;
            position: relative;
            z-index: 1;
        }

        .login-footer span { font-weight: 600; color: #ffffff; }
        .login-footer .separator { margin: 0 6px; color: rgba(255, 255, 255, 0.4); }

        @media (max-width: 480px) {
            .login-card { padding: 30px 20px 25px; }
            .login-logo h3 { font-size: 1.3rem; }
            .login-logo img { width: 90px; height: 90px; }
        }
    </style>
</head>
<body>

    <div class="login-overlay"></div>

    <div class="login-card">

        <div class="login-logo">
            <img src="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}" alt="Logo PDAM">
            <h3>PDAM Inventory</h3>
            <p>{{ __('auth.reset_password') }}</p>
            <div class="login-divider"></div>
        </div>

        <div class="info-text">
            <i class="bi bi-info-circle"></i>
            {{ __('auth.reset_password_info') }}
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-custom">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope"></i> {{ __('auth.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('auth.email_placeholder') }}">
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-send"></i> {{ __('auth.send_reset_link') }}
            </button>

            <div class="back-link">
                <i class="bi bi-arrow-left"></i>
                <a href="{{ route('login') }}">{{ __('auth.back_to_login') }}</a>
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