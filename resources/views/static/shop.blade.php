<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Խանութ | BookStore</title>
    @vite(['resources/css/shop.css', 'resources/js/app.js'])
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo"></a>
            <ul>
                <li><a href="{{ route('home') }}">Գլխավոր</a></li>
                <li><a href="{{ route('about') }}">Մեր մասին</a></li>
                <li><a href="{{ route('shop.index') }}">Խանութ</a></li>
                <li><a href="{{ route('contact') }}">Կապ</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <header class="page-header">
            <p>Բացահայտիր լավագույն հեղինակներին և նրանց ստեղծագործությունները</p>
        </header>

        <section class="shop-section">
            <h2>Առկա գրքերը</h2>

            <!-- Նոր հիմնական շրջանակը -->
            <div class="shop-layout">
                
                <!-- ՁԱԽ ԿՈՂՄ. Ժանրերի բաժին -->
                <aside class="filters-sidebar">
                    <div class="filter-group">
                        <h3>Ժանրեր</h3>
                        <ul class="genre-list">
                            <li><a href="#">Բոլորը</a></li>
                            <li><a href="#">Արկածային</a></li>
                            <li><a href="#">Փիլիսոփայություն</a></li>
                            <li><a href="#">Մոդեռնիզմ</a></li>
                            <li><a href="#">Դրամա</a></li>
                            <li><a href="#">Դետեկտիվ</a></li>
                            <li><a href="#">Դասական</a></li>
                            <li><a href="#">Ֆանտաստիկա</a></li>
                            <li><a href={{ route('books.search') }}>Ընդլայնված որոնում</a></li>
                        </ul>
                    </div>
                </aside>

                <div class="main-content">
                    <div class="book-grid">
                        @foreach($books as $book)
                            <div class="book-card">
                                <div class="book-info">
                                    <h3>{{ $book->title }}</h3>
                                    
                                    <div class="author-box">
                                        <span>Հեղինակ՝</span>
                                        @if($book->authorRelation)
                                            <a href="{{ url('/author/' . $book->authorRelation->id) }}">
                                                {{ $book->authorRelation->name }}
                                            </a>
                                        @elseif($book->author)
                                            <strong>{{ $book->author }}</strong>
                                        @else
                                            <span class="unknown">Անհայտ հեղինակ</span>
                                        @endif
                                    </div>

                                    <p class="price">{{ number_format($book->price) }} ֏</p>
                                </div>

                                <div class="book-actions">
                                    <button class="btn-buy">Գնել հիմա</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> <!-- .main-content վերջ -->

            </div> <!-- .shop-layout վերջ -->
        </section>
    </div>

    <footer>
        <p>&copy; 2024 BookStore. Բոլոր իրավունքները պաշտպանված են:</p>
    </footer>

</body>
</html>