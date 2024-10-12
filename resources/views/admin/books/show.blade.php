<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
        }
        .table {
            width: 70%;
            margin: 20px auto;
            border-collapse: separate; /* Add space between cells */
            border-spacing: 0.5rem 0; /* Adjust spacing as needed */
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: middle; /* Vertically center text */
            text-align: left; /* Align text to the left */
        }
        .table th {
            background-color: #f8f9fa; /* Light gray background for header */
            font-weight: bold;
        }
        .btn-secondary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Book Details</h1>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{ $book->title }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $book->price }}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ $book->stock }}</td>
                </tr>
                <tr>
                    <th>Author</th>
                    <td><a href="{{ route('authors.show', $book->author_id) }}">{{ $book->author->name }}</a></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
