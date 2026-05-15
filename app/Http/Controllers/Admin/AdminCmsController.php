<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Illuminate\Support\Str;

class AdminCmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::latest()->paginate(10);
        return view('admin.cms.index', compact('pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        CmsPage::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Page created successfully.');
    }

    public function edit(CmsPage $cms)
    {
        return view('admin.cms.edit', compact('cms'));
    }

    public function update(Request $request, CmsPage $cms)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|string|max:255|unique:cms_pages,slug,' . $cms->id,
        ]);

        $cms->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.cms.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CmsPage $cms)
    {
        $cms->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}
