<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    //
    public function index(Request $request)
    {
        $books = Book::with(['author', 'category'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%{{$s}}%"))
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', [
            'books' => $books,
            'categories' => Category::orderaBy('name')->get(),
        ]);
    }
    public function show(Book $book)
    {
        $book->load(['auhor', 'category']);
        return view('catalog.show', compact('book'));
    }
}
