<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('header-title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/header.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <nav class="navbar">
        <div class="nav-container">
            <h1>🌿 BookNook</h1>
            <div class="nav-links">
                <a href="{{ route('home') }}">Գլխավոր</a>
                <a href="{{ route('contact') }}">Կապ</a>
                <a href="{{ route('about') }}">Մեր մասին</a>    
                <a href="{{ route('shop.index') }}">Խանութ</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}">Կառավարման վահանակ</a>
                @else
                    <a href="{{ route('login') }}">Մուտք</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h2>Գտիր քո հաջորդ պատմությունը</h2>
            <p>Բացահայտիր հազարավոր հետաքրքիր գրքեր մեկ վայրում</p>
            <button class="btn-hero">Սկսել որոնումը</button>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h3>Հանրաճանաչ գրքեր</h3>
            @yield('content')
        </div>
    </section>

    <footer class="footer">
        <p>© 2026 BookStore | Պատրաստված է սիրով</p>
    </footer>

</body>
</html>