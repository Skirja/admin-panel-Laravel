<!DOCTYPE html>
<html>
<head>
    <title>Authors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
        }
        .table-striped>tbody>tr:nth-of-type(odd)>td, .table-striped>tbody>tr:nth-of-type(odd)>th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Authors</h1>
        <a href="{{ route('authors.create') }}" class="btn btn-primary mb-3">Add Author</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Birth Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->birth_date }}</td>
                        <td>
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
</body>
</html>
