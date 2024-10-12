<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('admin.books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'author_id' => 'required|exists:authors,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('admin.books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'author_id' => 'required|exists:authors,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%{$query}%")->with('author')->get();
        if ($books->isEmpty()) {
            return back()->with('error', 'No books found.');
        }
        return view('admin.books.index', compact('books'));
    }
}
