<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restoran') — Lezzet Durağı</title>
    <meta name="description" content="@yield('meta_description', 'Lezzet Durağı Restoran — Online menü ve sipariş sistemi.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ───────────── CSS TOKENS ───────────── */
                :root {
            --clr-bg:        #0F172A;
            --clr-surface:   #1E293B;
            --clr-glass:     rgba(30, 41, 59, 0.7);
            --clr-border:    #334155;
            --clr-gold:      #F59E0B;
            --clr-gold-dark: #D97706;
            --clr-gold-light:rgba(245, 158, 11, 0.15);
            --clr-text:      #F8FAFC;
            --clr-text-mute: #94A3B8;
            --clr-danger:    #EF4444;
            --clr-success:   #10B981;
            --clr-warn:      #F59E0B;
            --radius-sm:     8px;
            --radius-md:     12px;
            --radius-lg:     16px;
            --shadow-sm:     0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md:     0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg:     0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition:    0.2s ease-in-out;
        }

        /* ───────────── RESET & BASE ───────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--clr-bg);
            background-image:
                #0F172A;
            color: var(--clr-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ───────────── SCROLLBAR ───────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--clr-bg); }
        ::-webkit-scrollbar-thumb { background: var(--clr-gold-dark); border-radius: 99px; }

        /* ───────────── NAVBAR ───────────── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--clr-border);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--clr-gold);
            letter-spacing: -0.5px;
        }

        .navbar-brand span { font-size: 1.5rem; }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .navbar-links a {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--clr-text-mute);
            transition: color var(--transition), background var(--transition);
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            color: var(--clr-gold);
            background: rgba(214, 168, 79, 0.1);
        }

        .cart-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--clr-gold);
            color: #0F172A;
            font-size: 0.7rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-left: 2px;
        }

        /* ───────────── MAIN CONTENT ───────────── */
        main {
            flex: 1;
            width: 100%;
            padding: 40px 32px;
            max-width: 1280px;
            margin: 0 auto;
            animation: fadeUp 0.45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ───────────── GLASS CARD ───────────── */
        .glass {
            background: var(--clr-glass);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--clr-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        /* ───────────── PAGE TITLE ───────────── */
        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--clr-gold);
            margin-bottom: 28px;
            letter-spacing: -0.5px;
        }

        .page-title small {
            display: block;
            font-size: 0.95rem;
            font-weight: 400;
            color: var(--clr-text-mute);
            margin-top: 4px;
            letter-spacing: 0;
        }

        /* ───────────── BUTTONS ───────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: transform var(--transition), box-shadow var(--transition), filter var(--transition);
        }

        .btn:hover  { transform: translateY(-2px); box-shadow: var(--shadow-sm); filter: brightness(1.1); }
        .btn:active { transform: translateY(0); }

        .btn-gold {
            background: var(--clr-gold);
            color: #0F172A;
        }

        .btn-danger  { background: var(--clr-danger); color: #fff; }
        .btn-success { background: var(--clr-success); color: #fff; }
        .btn-warn    { background: var(--clr-warn); color: #fff; }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--clr-border);
            color: var(--clr-text-mute);
        }
        .btn-ghost:hover { border-color: var(--clr-gold); color: var(--clr-gold); }

        /* ───────────── DIVIDER ───────────── */
        .divider {
            width: 100%;
            height: 1px;
            background: var(--clr-border);
            margin: 20px 0;
        }

        /* ───────────── FOOTER ───────────── */
        .footer {
            text-align: center;
            padding: 20px 32px;
            font-size: 0.8rem;
            color: var(--clr-text-mute);
            border-top: 1px solid var(--clr-border);
        }

        /* ───────────── RESPONSIVE ───────────── */
        @media (max-width: 768px) {
            .navbar { padding: 0 16px; }
            main    { padding: 24px 16px; }
            .navbar-links a span.nav-label { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <span>🍽️</span> Lezzet Durağı
    </a>
    <ul class="navbar-links">
        <li>
            <a href="{{ route('home') }}" id="nav-home" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <span>🏠</span><span class="nav-label">Ana Sayfa</span>
            </a>
        </li>
        <li>
            <a href="{{ route('menu') }}" id="nav-menu" class="{{ request()->routeIs('menu') ? 'active' : '' }}">
                <span>📋</span><span class="nav-label">Menü</span>
            </a>
        </li>
        <li>
            <a href="{{ route('cart') }}" id="nav-cart" class="{{ request()->routeIs('cart') ? 'active' : '' }}">
                <span>🛒</span><span class="nav-label">Sepet</span>
                @php $cartCount = count(session('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('orders') }}" id="nav-orders" class="{{ request()->routeIs('orders') ? 'active' : '' }}">
                <span>🧾</span><span class="nav-label">Siparişler</span>
            </a>
        </li>
    </ul>
</nav>

<main>
    @yield('content')
</main>

<footer class="footer">
    &copy; {{ date('Y') }} Lezzet Durağı Restoran. Tüm hakları saklıdır.
</footer>

@stack('scripts')
</body>
</html>
