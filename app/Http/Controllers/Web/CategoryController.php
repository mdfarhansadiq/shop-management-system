<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $categories = auth()->user()->categories()->withCount('products')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        auth()->user()->categories()->create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
