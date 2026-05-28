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
        $categories = \App\Models\BusinessCategory::whereNull('parent_id')->with('subcategories')->where('is_active', true)->orderBy('name')->get();

        return view('admin.services', compact('services', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'         => 'nullable|string|max:255',
            'name'             => 'required|string|max:255',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'icon'             => 'nullable|string',
            'banner_image'     => 'nullable|image|max:10240',
            'delivery_timeline'=> 'nullable|string|max:255',
            'requirements_text'=> 'nullable|string',
            'commission_rate'  => 'nullable|numeric|min:0',
            'commission_type'  => 'nullable|in:fixed,percentage',
            // Plan fields
            'basic_name'          => 'nullable|string|max:100',
            'basic_price'         => 'required|numeric|min:0',
            'basic_description'   => 'nullable|string',
            'basic_delivery'      => 'nullable|string|max:100',
            'basic_revisions'     => 'nullable|string|max:50',
            'basic_features'      => 'nullable|string',
            'standard_name'       => 'nullable|string|max:100',
            'standard_price'      => 'nullable|numeric|min:0',
            'standard_description'=> 'nullable|string',
            'standard_delivery'   => 'nullable|string|max:100',
            'standard_revisions'  => 'nullable|string|max:50',
            'standard_features'   => 'nullable|string',
            'premium_name'        => 'nullable|string|max:100',
            'premium_price'       => 'nullable|numeric|min:0',
            'premium_description' => 'nullable|string',
            'premium_delivery'    => 'nullable|string|max:100',
            'premium_revisions'   => 'nullable|string|max:50',
            'premium_features'    => 'nullable|string',
            // Platform fields
            'enable_platforms'    => 'nullable|boolean',
            'platform_names'      => 'nullable|array',
            'platform_prices'     => 'nullable|array',
            'platform_names.*'    => 'nullable|string',
            'platform_prices.*'   => 'nullable|numeric|min:0',
        ]);

        $plans = $this->buildPlans($request);
        $platforms = $this->buildPlatforms($request);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $this->compressAndSaveImage($request->file('banner_image'), 'services');
        }

        Service::create([
            'slug'             => Str::slug($validated['name']),
            'category'         => $validated['category'] ?? null,
            'name'             => $validated['name'],
            'short_description'=> $validated['short_description'] ?? null,
            'description'      => $validated['description'] ?? null,
            'min_price'        => $validated['basic_price'],
            'icon'             => $validated['icon'] ?? 'box',
            'banner_image'     => $bannerPath,
            'delivery_timeline'=> $validated['delivery_timeline'] ?? null,
            'requirements_text'=> $validated['requirements_text'] ?? null,
            'commission_rate'  => $validated['commission_rate'] ?? null,
            'commission_type'  => $validated['commission_type'] ?? 'percentage',
            'is_popular'       => $request->has('is_popular'),
            'is_active'        => $request->has('is_active'),
            'requires_domain'  => $request->has('requires_domain'),
            'enable_platforms' => $request->has('enable_platforms'),
            'platforms'        => $platforms,
            'features'         => $this->parseFeatures($request->input('basic_features', '')),
            'plans'            => $plans,
        ]);

        return redirect()->back()->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category'         => 'nullable|string|max:255',
            'name'             => 'required|string|max:255',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'icon'             => 'nullable|string',
            'banner_image'     => 'nullable|image|max:10240',
            'delivery_timeline'=> 'nullable|string|max:255',
            'requirements_text'=> 'nullable|string',
            'commission_rate'  => 'nullable|numeric|min:0',
            'commission_type'  => 'nullable|in:fixed,percentage',
            // Plan fields
            'basic_name'          => 'nullable|string|max:100',
            'basic_price'         => 'required|numeric|min:0',
            'basic_description'   => 'nullable|string',
            'basic_delivery'      => 'nullable|string|max:100',
            'basic_revisions'     => 'nullable|string|max:50',
            'basic_features'      => 'nullable|string',
            'standard_name'       => 'nullable|string|max:100',
            'standard_price'      => 'nullable|numeric|min:0',
            'standard_description'=> 'nullable|string',
            'standard_delivery'   => 'nullable|string|max:100',
            'standard_revisions'  => 'nullable|string|max:50',
            'standard_features'   => 'nullable|string',
            'premium_name'        => 'nullable|string|max:100',
            'premium_price'       => 'nullable|numeric|min:0',
            'premium_description' => 'nullable|string',
            'premium_delivery'    => 'nullable|string|max:100',
            'premium_revisions'   => 'nullable|string|max:50',
            'premium_features'    => 'nullable|string',
            // Platform fields
            'enable_platforms'    => 'nullable|boolean',
            'platform_names'      => 'nullable|array',
            'platform_prices'     => 'nullable|array',
            'platform_names.*'    => 'nullable|string',
            'platform_prices.*'   => 'nullable|numeric|min:0',
        ]);

        $plans = $this->buildPlans($request);
        $platforms = $this->buildPlatforms($request);

        $bannerPath = $service->banner_image;
        if ($request->hasFile('banner_image')) {
            if ($bannerPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($bannerPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $this->compressAndSaveImage($request->file('banner_image'), 'services');
        }

        $service->update([
            'slug'             => Str::slug($validated['name']),
            'category'         => $validated['category'] ?? null,
            'name'             => $validated['name'],
            'short_description'=> $validated['short_description'] ?? null,
            'description'      => $validated['description'] ?? null,
            'min_price'        => $validated['basic_price'],
            'icon'             => $validated['icon'] ?? 'box',
            'banner_image'     => $bannerPath,
            'delivery_timeline'=> $validated['delivery_timeline'] ?? null,
            'requirements_text'=> $validated['requirements_text'] ?? null,
            'commission_rate'  => $validated['commission_rate'] ?? null,
            'commission_type'  => $validated['commission_type'] ?? 'percentage',
            'is_popular'       => $request->has('is_popular'),
            'is_active'        => $request->has('is_active'),
            'requires_domain'  => $request->has('requires_domain'),
            'enable_platforms' => $request->has('enable_platforms'),
            'platforms'        => $platforms,
            'features'         => $this->parseFeatures($request->input('basic_features', '')),
            'plans'            => $plans,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    /**
     * Build the plans array from request inputs.
     */
    private function buildPlans(Request $request): array
    {
        return [
            'basic' => [
                'name'        => $request->input('basic_name', 'Basic'),
                'price'       => (float) $request->input('basic_price', 0),
                'description' => $request->input('basic_description', ''),
                'delivery'    => $request->input('basic_delivery', ''),
                'features'    => $this->parseFeatures($request->input('basic_features', '')),
                'active'      => $request->has('basic_active'),
            ],
            'standard' => [
                'name'        => $request->input('standard_name', 'Standard'),
                'price'       => $request->filled('standard_price') ? (float) $request->input('standard_price') : 0,
                'description' => $request->input('standard_description', ''),
                'delivery'    => $request->input('standard_delivery', ''),
                'features'    => $this->parseFeatures($request->input('standard_features', '')),
                'active'      => $request->has('standard_active'),
            ],
            'premium' => [
                'name'        => $request->input('premium_name', 'Premium'),
                'price'       => $request->filled('premium_price') ? (float) $request->input('premium_price') : 0,
                'description' => $request->input('premium_description', ''),
                'delivery'    => $request->input('premium_delivery', ''),
                'features'    => $this->parseFeatures($request->input('premium_features', '')),
                'active'      => $request->has('premium_active'),
            ],
        ];
    }

    /**
     * Build the platforms array from request inputs.
     */
    private function buildPlatforms(Request $request): array
    {
        $platforms = [];
        $names = $request->input('platform_names', []);
        $prices = $request->input('platform_prices', []);

        foreach ($names as $index => $name) {
            if (!empty($name)) {
                $platforms[] = [
                    'name' => $name,
                    'price' => isset($prices[$index]) ? (float) $prices[$index] : 0,
                ];
            }
        }
        return $platforms;
    }

    /**
     * Parse a newline-separated string into a clean array of features.
     */
    private function parseFeatures(?string $raw): array
    {
        if (is_null($raw)) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode("\n", $raw))));
    }

    public function destroy(Service $service)
    {
        if ($service->banner_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($service->banner_image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($service->banner_image);
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
            $file->storeAs($destinationPath, $fileName, 'public');
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
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($destinationPath . '/' . $fileName, file_get_contents($tempPath));
        unlink($tempPath);

        return $destinationPath . '/' . $fileName;
    }
}
