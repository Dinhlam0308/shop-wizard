<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $categories = \App\Models\Category::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view("admin.category.index", compact("categories"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load categories: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.category.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load category form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
                'slug' => 'required|string|max:255|unique:categories,slug',
            ]);
            $validated = $validator->validate();
            \App\Models\Category::create($validated);
            return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to store category: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);
            return view("admin.category.show", compact("category"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load category details: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);
            return view("admin.category.edit", compact("category"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load category edit form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            ]);
            $validated = $validator->validate();
            $category->update($validated);
            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update category: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete category: ' . $e->getMessage()]);
        }
    }
}
