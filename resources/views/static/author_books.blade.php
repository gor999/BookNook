<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/authorpage.css'])

</head>
<body>
    


<div class="container">
    <h2>Հեղինակ՝ {{ $author->name }}</h2>

    <div class="books-grid">
        @foreach($author->books as $book)
            <div class="book-card">
                <h4>{{ $book->title }}</h4>
                <p>Գինը՝ {{ $book->price }} ֏</p>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>