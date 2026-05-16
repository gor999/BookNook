<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro - Ընդլայնված որոնում</title>
    <style>
        :root {
            --primary: #4a90e2;
            --bg: #f4f7f6;
            --white: #ffffff;
            --shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .main-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 350px 1fr; /* Ձախում ֆիլտրը, աջում արդյունքները */
            gap: 30px;
        }

        /* Ֆիլտրի բլոկը */
        .search-container {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .search-container h3 {
            margin: 0 0 20px 0;
            font-size: 1.4rem;
            color: var(--primary);
            border-bottom: 2px solid var(--bg);
            padding-bottom: 10px;
        }

        .genre-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }

        .genre-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .genre-item:hover {
            background: var(--bg);
        }

        .genre-item input {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
        }

        .search-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        /* Արդյունքների բլոկը */
        .results-container h4 {
            margin: 0 0 20px 10px;
            font-size: 1.2rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--primary);
            transition: 0.3s;
        }

        .book-card:hover {
            transform: scale(1.02);
        }

        .book-title {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }

        .book-info {
            font-size: 0.9rem;
            color: #666;
            margin: 5px 0;
        }

        .price-tag {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 12px;
            background: #e8f0fe;
            color: var(--primary);
            border-radius: 20px;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 850px) {
            .main-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<nav>
    <li>
         <a href="{{ route('shop.index') }}">հետ վերադառնալ</a>
    </li>
</nav>
<div class="main-wrapper">
    <aside class="search-container">
        <h3>Ֆիլտրել</h3>
        <form action="{{ route('books.search') }}" method="GET">
            <p style="font-weight: 600; font-size: 0.9rem; color: #888;">ԸՍՏ ԺԱՆՐԻ</p>
            <div class="genre-group">
                @php
                    $availableGenres = [
                        1 => 'Մոդեռնիզմ', 2 => 'Փիլիսոփայություն', 3 => 'Դասական',
                        4 => 'Ֆանտաստիկա', 5 => 'Դրամա', 6 => 'Արկածային', 7 => 'Դետեկտիվ'
                    ];
                @endphp

                @foreach($availableGenres as $id => $name)
                <label class="genre-item">
                    <input type="checkbox" name="genre_ids[]" value="{{ $id }}" 
                        {{ is_array(request('genre_ids')) && in_array($id, request('genre_ids')) ? 'checked' : '' }}>
                    {{ $name }}
                </label>
                @endforeach
            </div>

            <button type="submit" class="search-btn">Կիրառել ֆիլտրը</button>
            <a href="{{ route('books.search') }}" style="display:block; text-align:center; margin-top:15px; color:#999; text-decoration:none; font-size:0.8rem;">Մաքրել բոլորը</a>
        </form>
    </aside>

    <main class="results-container">
        @if(isset($books) && $books->isNotEmpty())
            <h4>Գտնվել է {{ $books->count() }} գիրք</h4>
            <div class="books-grid">
                @foreach($books as $book)
                    <article class="book-card">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-info"><strong>Հեղինակ:</strong> {{ $book->author }}</p>
                        <p class="book-info"><strong>Ժանրեր:</strong> 
                            @foreach($book->genres as $genre)
                                <span style="font-style: italic;">{{ $genre->name }}{{ !$loop->last ? ',' : '' }}</span>
                            @endforeach
                        </p>
                        <div class="price-tag">{{ number_format($book->price) }} դրամ</div>
                    </article>
                @endforeach
            </div>
        @elseif(request()->has('genre_ids'))
            <div style="text-align: center; padding: 50px; background: white; border-radius: 15px;">
                <p>Այս ժանրերով գրքեր չեն գտնվել:</p>
            </div>
        @else
            <div style="text-align: center; padding: 50px; color: #888;">
                <p>Ընտրեք ժանրերը և սեղմեք որոնել՝ գրքեր տեսնելու համար:</p>
            </div>
        @endif
    </main>
</div>

</body>
</html>