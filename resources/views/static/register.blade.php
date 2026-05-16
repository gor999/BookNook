<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Գրանցում | Գրքի Աշխարհ</title>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,700;1,400&family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/register.css'])
</head>
<body>

    <div class="book-container">
        <div class="book">
            <div class="page left-page">
                <div class="page-content">
                    <h2 class="book-title">Բարի Գալուստ</h2>
                    <p class="book-description">Սկսեք ձեր սեփական պատմությունը մեր գրադարանում։ Գրանցվեք՝ նոր հնարավորություններ բացահայտելու համար։</p>
                    <div class="feather-icon">📖</div>
                    <a href="{{ route('login') }}" style="margin-top: 20px; color: #2c3e50; font-size: 14px;">Արդեն ունե՞ք հաշիվ</a>
                </div>
            </div>

            <div class="page right-page">
                <div class="page-content">
                    <h3 class="form-title">Ստեղծել Հաշիվ</h3>
                    
                    <form action="{{ route('register') }}" method="POST" class="book-form">
                        @csrf
                        <div class="input-group">
                            <label>Անուն</label>
                            <input type="text" name="name" placeholder="Ձեր անունը" required>
                        </div>

                        <div class="input-group">
                            <label>Էլ. Հասցե</label>
                            <input type="email" name="email" placeholder="example@mail.com" required>
                        </div>

                        <div class="input-group">
                            <label>Գաղտնաբառ</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>

                        <div class="input-group">
                            <label>Կրկնել Գաղտնաբառը</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="submit-btn">Գրանցվել</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>