<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      @vite(['resources/css/rolepage.css'], ['resources/js/app.js'])
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Role Management</h2>
                <li><a href="{{ route('admin.dashboard') }}">Կառավարման վահանակ</a></li>
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Անուն</th>
            <th>Email</th>
            <th>Ընթացիկ Դերը</th>
            <th>Փոխել Դերը</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                {{ $user->role ? $user->role->name : 'Դեր չունի' }}
            </td>
            <td>
                <form action="{{ route('admin.assignRole', $user->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select name="role_id" class="form-control">
                            <option value="">Ընտրեք դերը</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Պահպանել</button>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</body>
</html>