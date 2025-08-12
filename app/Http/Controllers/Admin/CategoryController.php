<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::with('parent')->get();
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'parent_id' => 'sometimes|exists:categories,id|integer|nullable'
        ]);
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string|min:5|max:255',
            'parent_id' => 'sometimes|exists:categories,id|integer|nullable'
        ]);
        if ($request->parent_id == $id) {
            return redirect()->route('caregories.index')->withErrors('The category can\'t be parent for it self');
        }
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
