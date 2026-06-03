<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPortfolioController extends Controller
{
    public function index()
    {
        $portfolios = \App\Models\Portfolio::with('service')->latest()->get();
        $services = \App\Models\Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.portfolios.index', compact('portfolios', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'name' => 'required|string|max:255',
            'link' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'google_drive_url' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $path = $request->hasFile('image') ? $request->file('image')->store('portfolios', 'public') : null;

        $service = $request->service_id ? \App\Models\Service::find($request->service_id) : null;
        $sectionName = $service ? $service->name : 'General';

        \App\Models\Portfolio::create([
            'service_id' => $request->service_id,
            'section' => $sectionName,
            'name' => $request->name,
            'link' => $request->link,
            'youtube_url' => $request->youtube_url,
            'google_drive_url' => $request->google_drive_url,
            'image' => $path,
            'is_active' => true,
        ]);

        return back()->with('success', 'Portfolio item added successfully.');
    }

    public function update(Request $request, \App\Models\Portfolio $portfolio)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'name' => 'required|string|max:255',
            'link' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'google_drive_url' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($portfolio->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->image = $request->file('image')->store('portfolios', 'public');
        }

        $service = $request->service_id ? \App\Models\Service::find($request->service_id) : null;
        $sectionName = $service ? $service->name : 'General';

        $portfolio->service_id = $request->service_id;
        $portfolio->section = $sectionName;
        $portfolio->name = $request->name;
        $portfolio->link = $request->link;
        $portfolio->youtube_url = $request->youtube_url;
        $portfolio->google_drive_url = $request->google_drive_url;
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
