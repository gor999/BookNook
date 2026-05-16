<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Աղբաման - Ջնջված Գրքեր</title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"> -->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px;
            color: #333;
        }
        .container {
            max-width: 900px;
            background: white;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h1 {
            color: #e74c3c;
            text-align: center;
            border-bottom: 2px solid #f4f7f6;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #e74c3c;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .status-badge {
            background: #fdeaea;
            color: #e74c3c;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .date {
            color: #888;
            font-size: 13px;
        }
        .empty-msg {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
        .btn-home {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        .btn-restore {
    display: inline-block;
    background-color: #3498db;
    color: white;
    padding: 5px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 12px;
    margin: 5px 0;
    transition: background 0.3s;
}

.btn-restore:hover {
    background-color: #2980b9;
}

    </style>
</head>
<body>

<div class="container">
    <a href="/admin/dashboard" class="btn-home">← Հետ դեպի Dashboard</a>
    <h1>🗑 Ջնջված Գրքերի Աղբաման</h1>

    @if($books->isEmpty())
        <div class="empty-msg">Աղբամանը դատարկ է:</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Վերնագիր</th>
                    <th>Հեղինակ</th>
                    <th>Գին</th>
                    <th>Ջնջման ամսաթիվ</th>
                </tr>
                <tr>
                
                </tr>
            </thead>
            <tbody>
                    
                        <a href="{{ route('trash.restoreAll') }}" class="btn-restore">Վերականգնել բոլորը</a>
                    
                    </th>
                @foreach($books as $book)
                    <tr>
                        <td><strong>{{ $book->title }}</strong></td>
                        <td>{{ $book->author }}</td>
                        <td>{{ number_format($book->price) }} դր.</td>
                        <td>
                            <span class="status-badge">Ջնջված</span><br>
                            <a href="{{ route('trash.restore', $book->id) }}" class="btn-restore">
        🔄 Վերականգնել
    </a>
                            <span class="date">{{ $book->deleted_at->format('d.m.Y H:i') }}</span>
                        </td>
                    </tr>

                @endforeach
               
            </tbody>
        </table>
    @endif
</div>

</body>
</html>