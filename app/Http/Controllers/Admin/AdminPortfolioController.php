<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPortfolioController extends Controller
{
    public function index()
    {
        $portfolios = \App\Models\Portfolio::latest()->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'link' => 'nullable|string',
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('portfolios', 'public');

        \App\Models\Portfolio::create([
            'section' => $request->section,
            'name' => $request->name,
            'link' => $request->link,
            'image' => $path,
            'is_active' => true,
        ]);

        return back()->with('success', 'Portfolio item added successfully.');
    }

    public function update(Request $request, \App\Models\Portfolio $portfolio)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'link' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($portfolio->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->image = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio->section = $request->section;
        $portfolio->name = $request->name;
        $portfolio->link = $request->link;
        $portfolio->save();

        return back()->with('success', 'Portfolio item updated successfully.');
    }

    public function toggle(\App\Models\Portfolio $portfolio)
    {
        $portfolio->update(['is_active' => !$portfolio->is_active]);
        return back()->with('success', 'Portfolio item status updated.');
    }

    public function destroy(\App\Models\Portfolio $portfolio)
    {
        if ($portfolio->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($portfolio->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image);
        }
        $portfolio->delete();
        return back()->with('success', 'Portfolio item deleted.');
    }
}
