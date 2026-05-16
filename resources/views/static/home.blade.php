@extends('layouts.main')

@section('content')

@vite(['resources/css/shop.css'])

<div class="book-grid">
    @forelse($books as $book)
    
    <div class="book-card">
        <div class="book-info">
           <h3>{{ $book->title }}</h3>
    <p class="price">{{ number_format($book->price) }} ֏</p>

    <p class="author">
    Հեղինակ՝ 
    @if($book->authorRelation)
        <a href="/author/{{ $book->authorRelation->id }}">
            {{ $book->authorRelation->name }}
        </a>
        @elseif($book->author)
            <span>{{ $book->author }}</span>
        @else
        <span>Անհայտ հեղինակ</span>
        @endif
    </p>




        </div>
    </div>
    @empty
    <p class="empty-state">Գրքեր չեն գտնվել:</p>
    @endforelse
</div>
@endsection