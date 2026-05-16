<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Գրախանութ Մուտք</title>
    @vite(['resources/css/login.css'])
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="{{ route('login.post') }}" method="POST">
            @csrf   
            <h2>📚 BookNook Մուտք</h2>
            <p>Բարի վերադարձ։ Մուտք գործեք շարունակելու համար։</p>
            
            <div class="input-group">
                <label for="email">Էլ․ հասցե</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="input-group">
                <label for="password">Գաղտնաբառ</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="options">
                <label><input type="checkbox"> Հիշել ինձ</label>
                <a href="#">Մոռացե՞լ եք գաղտնաբառը</a>
            </div>
            
            <button type="submit" class="login-btn">Մուտք</button>

            
            <p class="register">
                Չունե՞ք հաշիվ։
                <a href="{{ route('register') }}">Գրանցվել</a>
            </p>
            <p class="admin-link">
                <a href="{{ route('home') }}">Գլխավոր էջ</a>
            </p>
        </form>
    </div>
</body>
</html>
