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
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'banner_image' => 'nullable|image|max:10240',
            'delivery_timeline' => 'nullable|string|max:255',
            'requirements_text' => 'nullable|string',
            'commission_rate' => 'nullable|numeric|min:0',
            'commission_type' => 'nullable|in:fixed,percentage',
            'features' => 'required|string',
        ]);

        $featuresArray = array_map('trim', explode("\n", $validated['features']));
        $featuresArray = array_filter($featuresArray);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $this->compressAndSaveImage($request->file('banner_image'), 'services');
        }

        Service::create([
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'name' => $validated['name'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'] ?? null,
            'min_price' => $validated['min_price'],
            'icon' => $validated['icon'] ?? 'box',
            'banner_image' => $bannerPath,
            'delivery_timeline' => $validated['delivery_timeline'] ?? null,
            'requirements_text' => $validated['requirements_text'] ?? null,
            'commission_rate' => $validated['commission_rate'] ?? null,
            'commission_type' => $validated['commission_type'] ?? 'percentage',
            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),
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
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'banner_image' => 'nullable|image|max:10240',
            'delivery_timeline' => 'nullable|string|max:255',
            'requirements_text' => 'nullable|string',
            'commission_rate' => 'nullable|numeric|min:0',
            'commission_type' => 'nullable|in:fixed,percentage',
            'features' => 'required|string',
        ]);

        $featuresArray = array_map('trim', explode("\n", $validated['features']));
        $featuresArray = array_filter($featuresArray);

        $bannerPath = $service->banner_image;
        if ($request->hasFile('banner_image')) {
            // Delete old one
            if ($bannerPath && \Illuminate\Support\Facades\Storage::exists('public/' . $bannerPath)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $bannerPath);
            }
            $bannerPath = $this->compressAndSaveImage($request->file('banner_image'), 'services');
        }

        $service->update([
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'name' => $validated['name'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'] ?? null,
            'min_price' => $validated['min_price'],
            'icon' => $validated['icon'] ?? 'box',
            'banner_image' => $bannerPath,
            'delivery_timeline' => $validated['delivery_timeline'] ?? null,
            'requirements_text' => $validated['requirements_text'] ?? null,
            'commission_rate' => $validated['commission_rate'] ?? null,
            'commission_type' => $validated['commission_type'] ?? 'percentage',
            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),
            'features' => $featuresArray,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->banner_image && \Illuminate\Support\Facades\Storage::exists('public/' . $service->banner_image)) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $service->banner_image);
        }
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    /**
     * Toggle service active/inactive status.
     */
    public function toggle(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $status = $service->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Service '{$service->name}' has been {$status}.");
    }

    /**
     * Helper to automatically compress uploaded image under 200KB and save it.
     */
    private function compressAndSaveImage($file, $destinationPath)
    {
        $info = getimagesize($file->getRealPath());
        $mime = $info['mime'];

        // Load image based on mime
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getRealPath());
                // Handle transparency for PNG to JPEG conversion
                $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image);
                $image = $bg;
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = imagecreatefromwebp($file->getRealPath());
                } else {
                    $image = false;
                }
                break;
            default:
                $image = false;
        }

        // Fallback: if GD fails, copy directly
        if (!$image) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/' . $destinationPath, $fileName);
            return $destinationPath . '/' . $fileName;
        }

        // Target under 200KB (204800 bytes)
        $tempPath = tempnam(sys_get_temp_dir(), 'img');
        $quality = 85;
        
        do {
            imagejpeg($image, $tempPath, $quality);
            $size = filesize($tempPath);
            $quality -= 10;
        } while ($size > 204800 && $quality >= 10);

        imagedestroy($image);

        // Save compressed file to storage
        $fileName = uniqid() . '.jpg';
        $finalPath = 'public/' . $destinationPath . '/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::put($finalPath, file_get_contents($tempPath));
        unlink($tempPath);

        return $destinationPath . '/' . $fileName;
    }
}
