<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
        }

        $services = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'min_price' => 'required|numeric|min:0',
            'icon' => 'required|string',
            'features' => 'required|string',
        ]);

        $featuresArray = array_map('trim', explode("\n", $validated['features']));
        $featuresArray = array_filter($featuresArray);

        Service::create([
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'name' => $validated['name'],
            'short_description' => $validated['short_description'],
            'min_price' => $validated['min_price'],
            'icon' => $validated['icon'],
            'is_popular' => $request->has('is_popular'),
            'features' => $featuresArray,
        ]);

        return redirect()->back()->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'min_price' => 'required|numeric|min:0',
            'icon' => 'required|string',
            'features' => 'required|string',
        ]);

        $featuresArray = array_map('trim', explode("\n", $validated['features']));
        $featuresArray = array_filter($featuresArray);

        $service->update([
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'name' => $validated['name'],
            'short_description' => $validated['short_description'],
            'min_price' => $validated['min_price'],
            'icon' => $validated['icon'],
            'is_popular' => $request->has('is_popular'),
            'features' => $featuresArray,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }
}
