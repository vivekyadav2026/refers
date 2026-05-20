<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketingMaterial;

class AdminMarketingMaterialController extends Controller
{
    public function index()
    {
        $materials = MarketingMaterial::latest()->paginate(10);
        return view('admin.marketing.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.marketing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,document',
            'file' => 'required|file',
        ]);

        $filePath = $request->file('file')->store('marketing', 'public');

        MarketingMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file_path' => $filePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.marketing.index')->with('success', 'Marketing Material created successfully');
    }

    public function edit(MarketingMaterial $marketing)
    {
        return view('admin.marketing.edit', compact('marketing'));
    }

    public function update(Request $request, MarketingMaterial $marketing)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,document',
            'file' => 'nullable|file',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('marketing', 'public');
            $marketing->file_path = $filePath;
        }

        $marketing->title = $request->title;
        $marketing->description = $request->description;
        $marketing->type = $request->type;
        $marketing->is_active = $request->has('is_active');
        $marketing->save();

        return redirect()->route('admin.marketing.index')->with('success', 'Marketing Material updated successfully');
    }

    public function destroy(MarketingMaterial $marketing)
    {
        $marketing->delete();
        return redirect()->route('admin.marketing.index')->with('success', 'Marketing Material deleted successfully');
    }
}
