<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::withCount('books')->get());
    }

    public function show(Request $request, $id)
    {
        $author = Author::with('books')->find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        return response()->json($author);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author = Author::create($request->all());
        return response()->json(['message' => 'Author created successfully!', 'author' => $author], 201);
    }

    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author->update($request->all());
        return response()->json(['message' => 'Author updated successfully!', 'author' => $author], 200);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(['message' => 'Author deleted successfully!'], 200);
    }
}
