<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
        $categories= Category::withCount('books')->latest()->paginate(10);
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
       return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data =$request->validate([
            'name'=>'required|string|max:255'
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        $category->load('books');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
         return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
         $data =$request->validate([
            'name'=>'required|string|max:255'
        ]);

        Category::update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
         return redirect()->route('admin.categories.index')->with('success', 'Deleted successfully');
    }
}
