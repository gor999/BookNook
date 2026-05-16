<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Կապ մեզ հետ | BookNook</title>
    
    <!-- Подключаем шрифты -->
    <link href="https://googleapis.com" rel="stylesheet">
    
    <!-- Правильное подключение Vite -->
    @vite(['resources/css/contact.css'])
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Գլխավոր</a></li>
            <li><a href="{{ route('about') }}">Մեր մասին</a></li>
            <li><a href="{{ route('shop.index') }}">Խանութ</a></li>
            @auth
                <li><a href="{{ route('admin.dashboard') }}">Կառավարման վահանակ</a></li>
                <li>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Ելք
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Մուտք</a></li>
            @endauth
        </ul>   
    </nav>
    <div class="contact-container">
        <div class="contact-box">
            <h1>📩 Կապ մեզ հետ</h1>
            <p>Ունե՞ք հարցեր: Գրեք մեզ և մենք կպատասխանենք ձեզ:</p>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" required placeholder=" ">
                    <label>Ձեր անունը</label>
                </div>

                <div class="input-group">
                    <input type="email" name="email" required placeholder=" ">
                    <label>Ձեր էլ․ հասցեն</label>
                </div>

                <div class="input-group">
                    <textarea name="message" required placeholder=" "></textarea>
                    <label>Ձեր հաղորդագրությունը</label>
                </div>

                <button type="submit" class="btn-submit">Ուղարկել հաղորդագրությունը</button>
            </form>
        </div>
    </div>

</body>
</html>
