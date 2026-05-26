<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BusinessCategory;
use Illuminate\Support\Str;

class AdminBusinessCategoryController extends Controller
{
    public function index()
    {
        $categories = BusinessCategory::whereNull('parent_id')->with('subcategories')->latest()->get();
        return view('admin.business_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_categories,name',
            'parent_id' => 'nullable|exists:business_categories,id'
        ]);

        BusinessCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_active' => true
        ]);

        return back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, BusinessCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:business_categories,id'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function toggle(BusinessCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        // If it's a parent category, toggle all children too for consistency
        if(is_null($category->parent_id) && !$category->is_active) {
            $category->subcategories()->update(['is_active' => false]);
        }

        return back()->with('success', 'Category status updated.');
    }

    public function destroy(BusinessCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
