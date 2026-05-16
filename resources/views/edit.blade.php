<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <title>Խմբագրել գիրքը</title>
    @vite(['resources/css/edit.css'])
</head>
<body class="container mt-5">

    <div class="mb-4">
        <a href="{{ route('shop.index') }}" class="btn btn-secondary">Վերադառնալ գրքերի ցանկին</a>
    <h2>Խմբագրել գիրքը</h2>

    <!-- Action-ի մեջ նշում ենք update route-ը -->
    <form action="{{ route('shop.update', $book->id) }}" method="POST">
        @csrf
        <!-- Կարևոր է. Laravel-ին պետք է ասել, որ սա PUT (թարմացման) հարցում է -->
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Գրքի անվանումը</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Հեղինակ</label>
            <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Գինը</label>
            <input type="number" name="price" class="form-control" value="{{ $book->price }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Պահպանել փոփոխությունները</button>
        <a href="{{ route('shop.index') }}" class="btn btn-secondary">Չեղարկել</a>
    </form>
</div>
</body>
</html>
