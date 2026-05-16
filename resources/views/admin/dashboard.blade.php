<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNook | Admin Panel</title>
    @vite(['resources/css/admindash.css'], ['resources/js/app.js'])
    <!-- <link rel="stylesheet" href="{{ asset('resources/css/admindash.css') }}"> -->
     <!-- <link rel="stylesheet" href="{{ asset('css/admindash.css') }}"> -->

</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Գլխավոր</a></li>
            <li><a href="{{ route('contact') }}">Կապ</a></li>
            <li><a href="{{ route('about') }}">Մեր մասին</a></li>
            <li><a href="{{ route('shop.index') }}">Խանութ</a></li>
            <li><a href="{{ route('trash')}}">Աղբաման</a></li>
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
                        <li><a class="auth-user"> Բարի գալուստ, {{ auth()->user()->name }}!</a></li>
                            <a class="user-rules" href="{{ route('admin.roles') }}">Կարգավորումներ</a>  
                        </li>
            @else
                <li><a href="{{ route('login') }}">Մուտք</a></li>
            @endauth
        </ul>
    </nav>

    <div class="container"> 
        <header>
            <h1>📚 BookNook Admin</h1>
            <p>Կառավարման վահանակ</p>
        </header>


        <section class="add-book-section">
            <form action="{{ route('shop.store') }}" method="POST" class="book-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" placeholder="Գրքի անվանումը" required>
                    <input type="text" name="author" placeholder="Հեղինակը" required>
                    <input type="number" name="price" placeholder="Գինը" required>
                    <button type="submit" class="btn-add">➕ Ավելացնել</button>
                </div>
            </form>
        </section>

    



        <div class="book-grid">
            @forelse($books as $book)
            <div class="book-card">
                <div class="book-info">
                    <h3>{{ $book->title }}</h3>
                    <p class="author">Հեղինակ՝ <span>{{ $book->author }}</span></p>
                    <p class="price">{{ number_format($book->price) }} ֏</p>
                </div>
                
<div class="book-actions">
    <!-- Խմբագրել -->
    <a href="{{ route('admin.books.edit', $book->id, $book->title) }}" class="btne">Խմբագրել</a>

    <!-- Ջնջել -->
    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
        @if(auth()->user()->role && auth()->user()->role->slug === 'admin')
    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Վստա՞հ եք, որ ուզում եք ջնջել');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Ջնջել</button>
    </form>
@endif
    </form>
        </div>
            </div>  
            @empty
            <p class="empty-state">Ցուցակը դատարկ է...</p>
            @endforelse
        </div>
    </div>

</body>
</html>
