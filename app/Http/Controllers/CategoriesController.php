<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        $parentCategories = Category::whereNull('parent_id')->orderBy('order')->withCount('children')->get();
        $categories->load('children');
        $parentCategories->load('children');
        return view('categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'color_code' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $lastOrder= Category::max('order')??0;
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'color_code' => $request->color_code,
            'parent_id' => $request->parent_id,
            'order' => $lastOrder + 1,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'color_code' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $row) {
            Category::where('id', $row['id'])->update(['order' => $row['order']]);
        }

        return response()->json(['success' => true]);
    }
}
