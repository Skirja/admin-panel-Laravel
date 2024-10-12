<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $recentBooks = Book::with('author')->orderBy('created_at', 'desc')->take(3)->get();
        $authorsWithBookCount = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(3)
            ->get();

        $searchQuery = $request->query('query');
        $searchType = $request->query('type');

        $searchResults = null;
        if ($searchQuery) {
            if ($searchType === 'book') {
                $searchResults = Book::with('author')
                    ->where('title', 'like', "%{$searchQuery}%")
                    ->get();
            } elseif ($searchType === 'author') {
                $searchResults = Author::withCount('books')
                    ->where('name', 'like', "%{$searchQuery}%")
                    ->get();
            }
            if ($searchResults->isEmpty()) {
                return back()->with('error', 'No results found.');
            }
        }


        return view('admin.dashboard', compact(
            'totalBooks',
            'totalAuthors',
            'recentBooks',
            'authorsWithBookCount',
            'searchResults',
            'searchQuery',
            'searchType'
        ));
    }
}
