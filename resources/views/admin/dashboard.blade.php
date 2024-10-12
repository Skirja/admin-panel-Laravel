<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
        }
        .card-body {
            padding: 1.5rem;
        }
        h1 {
            font-size: 2rem;
        }
        h2 {
            font-size: 1.5rem;
        }
        .card-title {
            font-size: 1.5rem;
        }
        .card-text {
            font-size: 1rem;
        }
        table {
            font-size: 1rem;
        }
        .display-4 {
            font-size: 3rem;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.index') }}">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('authors.index') }}">Authors</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h1 class="text-center">Welcome, {{ Auth::user()->name }}!</h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Books</h5>
                        <p class="card-text display-4 text-center">{{ $totalBooks }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Authors</h5>
                        <p class="card-text display-4 text-center">{{ $totalAuthors }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Recent Books Added</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBooks as $book)
                            <tr>
                                <td><a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a></td>
                                <td><a href="{{ route('authors.show', $book->author_id) }}">{{ $book->author->name }}</a></td>
                                <td>{{ $book->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Author's Book Count</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Book Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authorsWithBookCount as $author)
                            <tr>
                                <td><a href="{{ route('authors.show', $author->id) }}">{{ $author->name }}</a></td>
                                <td>{{ $author->books_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="query" placeholder="Search by Book Title or Author Name" value="{{ $searchQuery }}">
                        <select class="form-select" name="type">
                            <option value="book" {{ $searchType === 'book' ? 'selected' : '' }}>Book</option>
                            <option value="author" {{ $searchType === 'author' ? 'selected' : '' }}>Author</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        @if($searchResults)
            <div class="row mb-4">
                <div class="col-12">
                    <h2>Search Results</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title/Author</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($searchResults as $result)
                                <tr>
                                    <td>
                                        @if($searchType === 'book')
                                            <a href="{{ route('books.show', $result->id) }}">{{ $result->title }}</a> by <a href="{{ route('authors.show', $result->author_id) }}">{{ $result->author->name }}</a>
                                        @else
                                            <a href="{{ route('authors.show', $result->id) }}">{{ $result->name }}</a> ({{ $result->books_count }} books)
                                        @endif
                                    </td>
                                    <td>
                                        @if($searchType === 'book')
                                            <a href="{{ route('books.show', $result->id) }}">View Details</a>
                                        @else
                                            <a href="{{ route('authors.show', $result->id) }}">View Details</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
</body>
</html>
