<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Author::create($request->all());
        return redirect()->route('authors.index')->with('success', 'Author created successfully!');
    }


    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $author->update($request->all());
        return redirect()->route('authors.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully!');
    }

    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $authors = Author::where('name', 'like', "%{$query}%")->get();
        if ($authors->isEmpty()) {
            return back()->with('error', 'No authors found.');
        }
        return view('admin.authors.index', compact('authors'));
    }
}
