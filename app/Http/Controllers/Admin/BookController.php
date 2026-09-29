<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $books = Book::with(['author', 'category'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->author_id, fn($q, $id) => $q->where('author_id', $id))
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', [
            'books' => $books,
            'authors' => Author::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.books.create', [
            'authors' => Author::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
        ]);

        $data['avilable_copies'] = $data['total_copies'];
        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Books Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $book->load(['author', 'category']);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
        return view('admin.books.edit', [
            'book' => $book,
            'authors' => Author::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
        ]);
        $diff = $data['total_copies'] - $book->total_copies;
        $data['available_copies'] = max(0, $book->available_copies + $diff);

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
          $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success','Deleted Successfully');
    }
}
