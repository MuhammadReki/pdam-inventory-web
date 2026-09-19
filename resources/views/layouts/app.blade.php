<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - PDAM Payakumbuh Inventory</title>

    <!-- FAVICON LOGO PDAM -->
<link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-pdam.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon-pdam.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/images/favicon-pdam.png') }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
        
        body {
            background-image: url('{{ asset("assets/images/Background Web PDAM.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        /* ===== SIDEBAR ===== */
        .sidebar-premium {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: linear-gradient(180deg, #0a1628 0%, #1a2d5c 50%, #0d1b3e 100%);
            z-index: 1000;
            padding: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 8px 0 40px rgba(0, 0, 0, 0.4);
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
        }
        
        .sidebar-premium::-webkit-scrollbar {
            width: 3px;
        }
        .sidebar-premium::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-premium::-webkit-scrollbar-thumb {
            background: rgba(79, 195, 247, 0.3);
            border-radius: 10px;
        }
        
        /* Brand Area */
        .sidebar-brand-premium {
            padding: 28px 24px 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: relative;
        }
        
        .sidebar-brand-premium::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 20%;
            right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #4fc3f7, transparent);
            opacity: 0.5;
        }
        
        .sidebar-brand-premium .brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #4fc3f7, #0288d1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #fff;
            box-shadow: 0 4px 20px rgba(79, 195, 247, 0.3);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 4px 20px rgba(79, 195, 247, 0.3); }
            50% { box-shadow: 0 4px 40px rgba(79, 195, 247, 0.6); }
        }
        
        .sidebar-brand-premium h3 {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.3rem;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .sidebar-brand-premium .brand-sub {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 400;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        
        /* Menu Items */
        .sidebar-menu-premium {
            padding: 20px 14px;
        }
        
        .sidebar-menu-premium .menu-label {
            color: rgba(255,255,255,0.3);
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 0 12px;
            margin: 20px 0 12px 0;
            font-weight: 700;
        }
        
        .sidebar-menu-premium .menu-label:first-child {
            margin-top: 0;
        }
        
        .sidebar-menu-premium .nav-link-premium {
            color: rgba(255,255,255,0.7);
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.88rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            position: relative;
            margin-bottom: 4px;
        }
        
        .sidebar-menu-premium .nav-link-premium::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 24px;
            background: linear-gradient(180deg, #4fc3f7, #0288d1);
            border-radius: 0 4px 4px 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-menu-premium .nav-link-premium:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            transform: translateX(4px);
        }
        
        .sidebar-menu-premium .nav-link-premium:hover::before {
            transform: translateY(-50%) scaleY(1);
        }
        
        .sidebar-menu-premium .nav-link-premium.active {
            background: rgba(79, 195, 247, 0.15);
            color: #ffffff;
        }
        
        .sidebar-menu-premium .nav-link-premium.active::before {
            transform: translateY(-50%) scaleY(1);
        }
        
        .sidebar-menu-premium .nav-link-premium i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu-premium .nav-link-premium:hover i {
            transform: scale(1.1);
            color: #4fc3f7;
        }
        
        .sidebar-menu-premium .nav-link-premium.active i {
            color: #4fc3f7;
        }
        
        .sidebar-menu-premium .nav-link-premium .badge-premium {
            margin-left: auto;
            background: linear-gradient(135deg, #4fc3f7, #0288d1);
            color: #fff;
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        
        .sidebar-menu-premium .nav-link-premium.logout-link {
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 20px;
            color: rgba(255, 107, 107, 0.7);
        }
        
        .sidebar-menu-premium .nav-link-premium.logout-link:hover {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content-premium {
            margin-left: 280px;
            padding: 28px 36px 40px 36px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        /* ===== TOP HEADER ===== */
        .top-header-premium {
            background: rgba(10, 22, 40, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 20px 28px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between; 
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            position: relative;      /* ⬅️ TAMBAH INI */
            z-index: 9998;           /* ⬅️ TAMBAH INI */
        }
        
        .top-header-premium .page-title h4 {
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        
        .top-header-premium .page-title p {
            margin: 0;
            color: rgba(255,255,255,0.6);
            font-size: 0.88rem;
        }
        
        .top-header-premium .page-title p i {
            color: #4fc3f7;
        }
        
        /* User Info */
        .user-info-premium {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-info-premium .user-avatar-premium {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4fc3f7, #0288d1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 20px rgba(79, 195, 247, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .user-info-premium .user-avatar-premium:hover {
            transform: scale(1.05) rotate(-5deg);
        }
        
        .user-info-premium .user-details .user-name {
            font-weight: 700;
            color: #ffffff;
            font-size: 0.95rem;
        }
        
        .user-info-premium .user-details .user-role {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Notification Bell */
        .notif-bell {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .notif-bell:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: scale(1.05);
        }
        
        .notif-bell .notif-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ff6b6b;
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
            border: 2px solid rgba(0,0,0,0.2);
        }
        
        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
        }
        
        /* ===== CARD ===== */
        .card-premium {
            background: rgba(10, 22, 40, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 28px 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            position: relative;      /* ⬅️ TAMBAH INI */
            z-index: 1;              /* ⬅️ TAMBAH INI */
        }
        
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.2);
            border-color: rgba(79, 195, 247, 0.1);
        }
        
        .card-premium .card-header-premium {
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding-bottom: 18px;
            margin-bottom: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .card-premium .card-header-premium h5 {
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }
        
        .card-premium .card-header-premium .badge-count {
            background: rgba(79, 195, 247, 0.15);
            color: #4fc3f7;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid rgba(79, 195, 247, 0.06);
        }
        
        /* ===== STATISTIK CARD ===== */
        .stat-card-premium {
            background: rgba(10, 22, 40, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 22px 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4fc3f7, #0288d1);
            opacity: 0;
            transition: all 0.4s ease;
        }
        
        .stat-card-premium:hover::before {
            opacity: 1;
        }
        
        .stat-card-premium:hover {
            transform: translateY(-6px);
            border-color: rgba(79, 195, 247, 0.1);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card-premium .stat-icon-premium {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-card-premium .stat-number-premium {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            margin: 4px 0 0 0;
            letter-spacing: -1px;
        }
        
        .stat-card-premium .stat-label-premium {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0;
        }
        
        /* ===== TABLE ===== */
        .table-premium {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        
        .table-premium thead th {
            background: rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 18px;
            border: none;
        }
        
        .table-premium thead th:first-child {
            border-radius: 12px 0 0 12px;
        }
        .table-premium thead th:last-child {
            border-radius: 0 12px 12px 0;
        }
        
        .table-premium tbody tr {
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }
        
        .table-premium tbody tr:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(79, 195, 247, 0.06);
            transform: scale(1.005);
        }
        
        .table-premium tbody td {
            padding: 14px 18px;
            border: none;
            vertical-align: middle;
            color: rgba(255,255,255,0.85);
            font-size: 0.88rem;
        }
        
        .table-premium tbody tr td:first-child {
            border-radius: 12px 0 0 12px;
        }
        .table-premium tbody tr td:last-child {
            border-radius: 0 12px 12px 0;
        }
        
        /* Badge Kode */
        .badge-kode-premium {
            background: rgba(79, 195, 247, 0.12);
            color: #4fc3f7;
            padding: 4px 14px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid rgba(79, 195, 247, 0.06);
        }
        
        /* Badge Stok */
        .badge-stok-premium {
            padding: 5px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.3px;
        }
        .badge-stok-premium.tersedia {
            background: rgba(46, 213, 115, 0.15);
            color: #2ed573;
            border: 1px solid rgba(46, 213, 115, 0.06);
        }
        .badge-stok-premium.menipis {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.06);
        }
        .badge-stok-premium.kritis {
            background: rgba(255, 107, 107, 0.15);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.06);
        }
        
        /* ===== BUTTON ===== */
        .btn-premium {
            background: linear-gradient(135deg, #4fc3f7, #0288d1);
            border: none;
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(79, 195, 247, 0.25);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 40px rgba(79, 195, 247, 0.4);
            color: #ffffff;
        }
        
        .btn-premium-sm {
            padding: 6px 16px;
            font-size: 0.8rem;
            border-radius: 10px;
        }
        
        .btn-premium-outline {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.7);
            box-shadow: none;
        }
        
        .btn-premium-outline:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.1);
            color: #ffffff;
            box-shadow: none;
        }
        
        /* ===== FOOTER ===== */
        .footer-premium {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
            border-top: 1px solid rgba(255,255,255,0.04);
        }
        
        .footer-premium span {
            color: rgba(79, 195, 247, 0.5);
            font-weight: 600;
        }
        
        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        
        /* ===== MOBILE TOGGLE ===== */
        .mobile-toggle-premium {
            display: none;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .mobile-toggle-premium:hover {
            background: rgba(255,255,255,0.1);
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .main-content-premium {
                padding: 20px 24px 40px 24px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar-premium {
                width: 280px;
                transform: translateX(-110%);
            }
            
            .sidebar-premium.show {
                transform: translateX(0);
            }
            
            .main-content-premium {
                margin-left: 0;
                padding: 16px;
            }
            
            .mobile-toggle-premium {
                display: block !important;
            }
            
            .top-header-premium {
                padding: 16px 20px;
                flex-direction: column;
                align-items: stretch;
            }
            
            .top-header-premium .page-title h4 {
                font-size: 1.2rem;
            }
            
            .stat-card-premium .stat-number-premium {
                font-size: 1.5rem;
            }
            
            .table-premium thead th {
                font-size: 0.6rem;
                padding: 10px 8px;
            }
            
            .table-premium tbody td {
                font-size: 0.75rem;
                padding: 10px 8px;
            }
            
            .card-premium {
                padding: 18px 16px;
            }
        }
        
        @media (max-width: 480px) {
            .stat-card-premium {
                padding: 16px 18px;
            }
            
            .stat-card-premium .stat-number-premium {
                font-size: 1.3rem;
            }
        }
        
        /* Overlay untuk sidebar mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* ===== ALERT ===== */
        .alert-premium {
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.06);
            backdrop-filter: blur(12px);
            padding: 16px 24px;
            font-weight: 500;
        }
        .alert-premium-success {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
            border-color: rgba(46, 213, 115, 0.06);
        }
        .alert-premium-danger {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border-color: rgba(255, 107, 107, 0.06);
        }
        .alert-premium .btn-close {
            filter: invert(1);
            opacity: 0.3;
        }

                /* ===== NOTIF DROPDOWN ===== */
        .notif-wrapper {
            position: relative;
            z-index: 9999;  
        }

        .notif-bell {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notif-bell:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: scale(1.05);
        }

        .notif-bell .notif-count {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            background: #ff6b6b;
            color: #fff;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid rgba(10,22,40,0.9);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .notif-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            width: 380px;
            max-width: calc(100vw - 40px);
            background: rgba(10, 22, 40, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            box-shadow: 0 12px 48px rgba(0,0,0,0.5);
            z-index: 99999;   
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .notif-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notif-dropdown-header {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-dropdown-header h6 {
            margin: 0;
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .notif-mark-read {
            font-size: 0.75rem;
            color: #4fc3f7;
            cursor: pointer;
            font-weight: 600;
            background: none;
            border: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .notif-mark-read:hover {
            background: rgba(79,195,247,0.1);
        }

        .notif-dropdown-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .notif-dropdown-body::-webkit-scrollbar {
            width: 4px;
        }
        .notif-dropdown-body::-webkit-scrollbar-thumb {
            background: rgba(79,195,247,0.3);
            border-radius: 10px;
        }

        .notif-empty {
            padding: 40px 20px;
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
        }

        .notif-item {
            display: flex;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notif-item:hover {
            background: rgba(255,255,255,0.04);
        }

        .notif-item.unread {
            background: rgba(79,195,247,0.04);
        }

        .notif-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .notif-item-content {
            flex: 1;
            min-width: 0;
        }

        .notif-item-title {
            font-weight: 600;
            color: #fff;
            font-size: 0.85rem;
            margin-bottom: 2px;
        }

        .notif-item-message {
            color: rgba(255,255,255,0.55);
            font-size: 0.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 4px;
        }

        .notif-item-time {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 4px;
    margin-top: 4px;
    font-size: 0.68rem;
}

        .notif-dropdown-footer {
            padding: 14px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            text-align: center;
        }

        .notif-dropdown-footer a {
            color: #4fc3f7;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .notif-dropdown-footer a:hover {
            color: #81d4fa;
        }

                /* ===== LANGUAGE SWITCHER ===== */
        .lang-switcher {
            position: relative;
            z-index: 9999;
        }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;    
            transition: all 0.3s ease;
        }

        .lang-btn:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-1px);
        }

        .lang-btn i {
            color: #4fc3f7;
            font-size: 1rem;
        }

        .lang-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            min-width: 200px;
            background: rgba(10, 22, 40, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            box-shadow: 0 12px 48px rgba(0,0,0,0.5);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 99999;
        }

        .lang-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .lang-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .lang-item:hover {
            background: rgba(255,255,255,0.06);
            color: #ffffff;
        }

        .lang-item.active {
            background: rgba(79, 195, 247, 0.15);
            color: #4fc3f7;
        }

        .lang-flag {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    
    <!-- Overlay Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar-premium" id="sidebarPremium">
        <!-- Brand -->
        <div class="sidebar-brand-premium">
            <div class="d-flex align-items-center gap-3">
                <div class="brand-icon" style="padding: 4px; background: transparent; box-shadow: none; animation: none; width: 80px; height: 80px; overflow: hidden; border-radius: 14px;">
    <img src="{{ asset('assets/images/LOGO-PDAM-ASLI-removebg-preview.png') }}" alt="PDAM" 
         style="width: 100%; height: 100%; object-fit: contain; display: block;">
</div>
                <div>
                    <h3>PDAM Inventory</h3>
                    <div class="brand-sub">Kota Payakumbuh</div>
                </div>
            </div>
        </div>
        
        <!-- Menu -->
        <div class="sidebar-menu-premium">
            <div class="menu-label">{{ __('menu.menu_utama') }}</div>
            
            <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> 
                <span>{{ __('menu.dashboard') }}</span>
                @if(request()->routeIs('dashboard'))
                    <span class="badge-premium">{{ __('form.aktif') }}</span>
                @endif
            </a>
            
            <a href="{{ route('barang.index') }}" class="nav-link-premium {{ request()->routeIs('barang.*') && !request()->routeIs('barang-masuk.*') && !request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
    <i class="bi bi-grid"></i> 
    <span>{{ __('menu.master_barang') }}</span>
    @if($totalBarang > 0)
        <span class="badge-premium">{{ $totalBarang }}</span>
    @endif
</a>
            
            <a href="{{ route('barang-masuk.index') }}" class="nav-link-premium {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
    <i class="bi bi-arrow-down-circle"></i> 
    <span>{{ __('menu.barang_masuk') }}</span>
    @if($totalMasuk > 0)
        <span class="badge-premium">{{ $totalMasuk }}</span>
    @endif
</a>
            
           <a href="{{ route('barang-keluar.index') }}" class="nav-link-premium {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
    <i class="bi bi-arrow-up-circle"></i> 
    <span>{{ __('menu.barang_keluar') }}</span>
    @if($totalKeluar > 0)
        <span class="badge-premium">{{ $totalKeluar }}</span>
    @endif
</a>
            
            <a href="{{ route('barang-list') }}" class="nav-link-premium {{ request()->routeIs('barang-list') ? 'active' : '' }}">
    <i class="bi bi-eye"></i> 
    <span>{{ __('menu.list_barang') }}</span>
    @if($totalBarang > 0)
        <span class="badge-premium">{{ $totalBarang }}</span>
    @endif
</a>

<a href="{{ route('laporan.index') }}" class="nav-link-premium {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-text"></i> 
    <span>Laporan</span>
</a>

<a href="{{ route('prediksi.index') }}" class="nav-link-premium {{ request()->routeIs('prediksi.*') ? 'active' : '' }}">
    <i class="bi bi-graph-up-arrow"></i> 
    <span>Prediksi Restock</span>
</a>
            
            <div class="menu-label">{{ __('menu.akun') }}</div>
            
            @auth
                <a href="{{ route('profile.edit') }}" class="nav-link-premium {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> 
                    <span>{{ __('menu.profile') }}</span>
                </a>
                
                <a href="#" class="nav-link-premium logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> 
                    <span>{{ __('menu.logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link-premium">
                    <i class="bi bi-box-arrow-in-right"></i> 
                    <span>{{ __('menu.login') }}</span>
                </a>
                <a href="{{ route('register') }}" class="nav-link-premium">
                    <i class="bi bi-person-plus"></i> 
                    <span>{{ __('menu.register') }}</span>
                </a>
            @endauth
        </div>
    </div>
    
    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content-premium">
        
        <!-- Top Header -->
        <div class="top-header-premium">
            <div class="d-flex align-items-center gap-3">
                <!-- Mobile Toggle -->
                <button class="mobile-toggle-premium" id="sidebarTogglePremium">
                    <i class="bi bi-list fs-4"></i>
                </button>
                
                <div class="page-title">
                    <h4>@yield('page-title', 'Dashboard')</h4>
                    <p>
                        <i class="bi bi-house-door me-1"></i> 
                        @yield('breadcrumb', __('menu.selamat_datang'))
                    </p>
                </div>
            </div>
            
                        @auth
            <div class="user-info-premium">

                <!-- ===== LANGUAGE SWITCHER ===== -->
                <div class="lang-switcher">
                    <button class="lang-btn" onclick="toggleLangMenu(event)">
                        <i class="bi bi-globe2"></i>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                        <i class="bi bi-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>

                    <div class="lang-dropdown" id="langDropdown">
                        <a href="#" class="lang-item {{ app()->getLocale() === 'id' ? 'active' : '' }}"
                           onclick="event.preventDefault(); switchLang('id')">
                            <span class="lang-flag">🇮🇩</span>
                            <span>{{ __('pengaturan.indonesia') }}</span>
                            @if(app()->getLocale() === 'id')
                                <i class="bi bi-check2 ms-auto"></i>
                            @endif
                        </a>
                        <a href="#" class="lang-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                           onclick="event.preventDefault(); switchLang('en')">
                            <span class="lang-flag">🇬🇧</span>
                            <span>{{ __('pengaturan.inggris') }}</span>
                            @if(app()->getLocale() === 'en')
                                <i class="bi bi-check2 ms-auto"></i>
                            @endif
                        </a>
                    </div>
                </div>

               <!-- Notification Bell + Dropdown -->
<div class="notif-wrapper">
    <div class="notif-bell" id="notifBell" title="Notifikasi">
        <i class="bi bi-bell fs-5"></i>
        <span class="notif-count" id="notifCount" style="display: none;">0</span>
    </div>

    <!-- Dropdown Notif -->
    <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-dropdown-header">
            <h6>🔔 Notifikasi</h6>
            <button class="notif-mark-read" onclick="markAllReadWeb(event)">Tandai semua</button>
        </div>
        <div class="notif-dropdown-body" id="notifBody">
            <div class="notif-empty">Memuat notifikasi...</div>
        </div>
        <div class="notif-dropdown-footer">
            <a href="{{ route('notifications.index') }}">
                Lihat semua notifikasi →
            </a>
        </div>
    </div>
</div>
                
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <div class="user-avatar-premium">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            @endauth
        </div>
        
        <!-- Alert -->
        @if(session('success'))
            <div class="alert alert-premium alert-premium-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-premium alert-premium-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Content -->
        @yield('content')
        
        <!-- Footer -->
        <div class="footer-premium">
            <i class="bi bi-building me-1"></i> 
            Sistem Inventory <span>PDAM Kota Payakumbuh</span> 
            &bull; 
            <span id="currentYear"></span>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ===== JAVASCRIPT ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ===== 1. SIDEBAR TOGGLE MOBILE =====
            const sidebar = document.getElementById('sidebarPremium');
            const toggleBtn = document.getElementById('sidebarTogglePremium');
            const overlay = document.getElementById('sidebarOverlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
            
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // ===== 2. CURRENT YEAR =====
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            
            // ===== 4. TOAST NOTIFICATION =====
            function showToast(icon, message, type = 'info') {
                const existingToast = document.querySelector('.toast-premium');
                if (existingToast) existingToast.remove();
                
                const toast = document.createElement('div');
                toast.className = 'toast-premium';
                toast.style.cssText = `
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    background: rgba(10, 22, 40, 0.9);
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                    border: 1px solid rgba(255,255,255,0.06);
                    border-radius: 16px;
                    padding: 16px 24px;
                    color: #ffffff;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    box-shadow: 0 8px 40px rgba(0,0,0,0.4);
                    z-index: 9999;
                    transform: translateY(100px);
                    opacity: 0;
                    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                    max-width: 400px;
                    font-family: 'Inter', sans-serif;
                `;
                
                toast.innerHTML = `
                    <span style="font-size: 1.5rem;">${icon}</span>
                    <span style="font-size: 0.9rem; font-weight: 500;">${message}</span>
                    <button onclick="this.parentElement.remove()" style="
                        background: transparent;
                        border: none;
                        color: rgba(255,255,255,0.3);
                        font-size: 1.2rem;
                        cursor: pointer;
                        padding: 0 4px;
                        transition: all 0.3s ease;
                    ">×</button>
                `;
                
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.transform = 'translateY(0)';
                    toast.style.opacity = '1';
                }, 100);
                
                setTimeout(() => {
                    toast.style.transform = 'translateY(100px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            }
            
            // ===== 5. ANIMATE COUNTER =====
            function animateCounter(element, target, duration = 1500) {
                const start = 0;
                const startTime = performance.now();
                
                function update(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const current = Math.floor(progress * target);
                    element.textContent = current;
                    
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        element.textContent = target;
                    }
                }
                
                requestAnimationFrame(update);
            }
            
            const statNumbers = document.querySelectorAll('.stat-number-premium');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.textContent);
                        if (!isNaN(target)) {
                            animateCounter(entry.target, target);
                            observer.unobserve(entry.target);
                        }
                    }
                });
            }, { threshold: 0.5 });
            
            statNumbers.forEach(num => observer.observe(num));
            
            // ===== 6. KEYBOARD SHORTCUT Ctrl+K =====
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[type="text"][placeholder*="Cari"]');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });
            
            // ===== 7. TABLE ROW ANIMATION =====
            document.querySelectorAll('.table-premium tbody tr').forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('animate-fade-in-up');
            });
            
            // ===== 8. WELCOME TOAST =====
            setTimeout(() => {
                const userName = document.querySelector('.user-name')?.textContent || 'User';
                showToast('👋', `Selamat datang kembali, ${userName}!`, 'info');
            }, 800);
            
            console.log('🚀 PDAM Inventory - Background PDAM Showcase');
        });

        // ===== NOTIFIKASI POLLING 3 DETIK =====
let lastNotifId = 0;
let notifDropdownOpen = false;

const notifBell = document.getElementById('notifBell');
const notifDropdown = document.getElementById('notifDropdown');
const notifCount = document.getElementById('notifCount');
const notifBody = document.getElementById('notifBody');

if (notifBell) {
    // Toggle dropdown saat lonceng diklik
    notifBell.addEventListener('click', function(e) {
        e.stopPropagation();
        notifDropdownOpen = !notifDropdownOpen;
        notifDropdown.classList.toggle('show', notifDropdownOpen);
        
        if (notifDropdownOpen) {
            loadNotifications(true);
        }
    });

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.notif-wrapper')) {
            notifDropdown.classList.remove('show');
            notifDropdownOpen = false;
        }
    });

    // Load notif pertama kali
    loadNotifications();
}

// Fungsi load notif
function loadNotifications(forceReload = false) {
    // Kalau dropdown kebuka, ambil SEMUA notif (bukan cuma yang baru)
    const sinceParam = (notifDropdownOpen || forceReload) ? 0 : lastNotifId;
    
    fetch('{{ route('notifications.latest') }}?since=' + sinceParam)
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Update badge
            if (data.unread_count > 0) {
                notifCount.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                notifCount.style.display = 'flex';
            } else {
                notifCount.style.display = 'none';
            }

            // Update list kalau dropdown kebuka
            if (notifDropdownOpen) {
                renderNotifList(data.notifications);
            }

            // Update last id (cuma kalau lebih besar)
            if (data.last_id && data.last_id > lastNotifId) {
                lastNotifId = data.last_id;
            }
        })
        .catch(err => console.log('Notif error:', err));
}
// Render list notif ke dropdown
function renderNotifList(notifs) {
    if (!notifs || notifs.length === 0) {
        notifBody.innerHTML = '<div class="notif-empty">🔕 Belum ada notifikasi</div>';
        return;
    }

    let html = '';
    notifs.forEach(n => {
        const colorMap = {
            danger: 'rgba(255,107,107,0.15)',
            warning: 'rgba(255,193,7,0.15)',
            success: 'rgba(46,213,115,0.15)',
            info: 'rgba(79,195,247,0.15)'
        };
        const bg = colorMap[n.type] || colorMap.info;

        // Format tanggal & jam lengkap
        const d = new Date(n.created_at);
        const tanggal = d.toLocaleDateString('id-ID', {
            day: '2-digit', month: 'short', year: 'numeric'
        });
        const jam = d.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
        });

        // Relative time
        const diffMs = Date.now() - d.getTime();
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMins / 60);
        const diffDays = Math.floor(diffHours / 24);
        
        let relative = '';
        if (diffMins < 1) relative = 'Baru saja';
        else if (diffMins < 60) relative = `${diffMins} menit lalu`;
        else if (diffHours < 24) relative = `${diffHours} jam lalu`;
        else if (diffDays < 7) relative = `${diffDays} hari lalu`;
        else relative = tanggal;

        html += `
            <div class="notif-item ${n.is_read ? '' : 'unread'}" onclick="openNotif(${n.id}, '${n.reference_type || ''}', '${n.reference_id || ''}')">
                <div class="notif-item-icon" style="background: ${bg};">
                    ${n.icon || '🔔'}
                </div>
                <div class="notif-item-content">
                    <div class="notif-item-title">${n.title}</div>
                    <div class="notif-item-message">${n.message}</div>
                    <div class="notif-item-time">
                        <span style="color: #4fc3f7; font-weight: 600;">📅 ${tanggal}</span>
                        <span style="margin-left: 8px; color: #4fc3f7; font-weight: 600;">🕐 ${jam}</span>
                        <span style="margin-left: 8px; color: #94a3b8; font-style: italic;">(${relative})</span>
                    </div>
                </div>
            </div>
        `;
    });
    notifBody.innerHTML = html;
}

// Handle klik notif
function openNotif(id, refType, refId) {
    fetch('/notifications/' + id + '/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        if (refType === 'Barang' && refId) {
            window.location.href = '/barang/' + refId + '/edit';
        } else if (refType === 'BarangMasuk') {
            window.location.href = '/barang-masuk';
        } else if (refType === 'BarangKeluar') {
            window.location.href = '/barang-keluar';
        } else {
            window.location.reload();
        }
    });
}

// Tandai semua dibaca (dari dropdown)
function markAllReadWeb(e) {
    e.stopPropagation();
    fetch('{{ route('notifications.read-all') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        notifCount.style.display = 'none';
        loadNotifications();
    });
}

// Refresh badge (dipanggil dari halaman lain)
window.refreshNotifBadge = function() {
    loadNotifications();
};

// Polling tiap 3 detik
setInterval(loadNotifications, 3000);

        // ===== LANGUAGE SWITCHER =====
        function toggleLangMenu(e) {
            e.stopPropagation();
            const dd = document.getElementById('langDropdown');
            if (dd) dd.classList.toggle('show');
        }

        function switchLang(locale) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('locale.switch') }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            
            const localeInput = document.createElement('input');
            localeInput.type = 'hidden';
            localeInput.name = 'locale';
            localeInput.value = locale;
            
            form.appendChild(csrfInput);
            form.appendChild(localeInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Tutup dropdown bahasa kalau klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.lang-switcher')) {
                const dd = document.getElementById('langDropdown');
                if (dd) dd.classList.remove('show');
            }
        });
    </script>
    @include('partials.ai-assistant')
</body>
</html>