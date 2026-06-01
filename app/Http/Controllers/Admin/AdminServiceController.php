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
            'enable_gst'       => 'nullable|boolean',
            'gst_percent'      => 'nullable|numeric|min:0|max:100',
            'domain_in_charge' => 'nullable|numeric|min:0',
            'domain_com_charge'=> 'nullable|numeric|min:0',
            // Dynamic Plan fields
            'plans'               => 'nullable|array',
            'plans.*.name'        => 'required|string|max:100',
            'plans.*.description' => 'nullable|string',
            'plans.*.delivery'    => 'nullable|string|max:100',
            'plans.*.features'    => 'nullable|string',

            // Dynamic Platform fields
            'enable_platforms'    => 'nullable|boolean',
            'platforms'           => 'nullable|array',
            'platforms.*.name'    => 'required|string|max:100',

            // Pricing Matrix
            'pricing_matrix'      => 'nullable|array',
        ]);

        $plans = $this->buildDynamicPlans($request);
        $platforms = $this->buildDynamicPlatforms($request);
        $pricingMatrix = $this->buildPricingMatrix($request, $platforms, $plans);

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
            'min_price'        => $this->calculateMinPrice($pricingMatrix),
            'icon'             => $validated['icon'] ?? 'box',
            'banner_image'     => $bannerPath,
            'delivery_timeline'=> $validated['delivery_timeline'] ?? null,
            'requirements_text'=> $validated['requirements_text'] ?? null,
            'commission_rate'  => $validated['commission_rate'] ?? null,
            'commission_type'  => $validated['commission_type'] ?? 'percentage',
            'is_popular'       => $request->boolean('is_popular'),
            'is_active'        => true,
            'requires_domain'  => $request->boolean('requires_domain'),
            'enable_gst'       => $request->boolean('enable_gst'),
            'gst_percent'      => $validated['gst_percent'] ?? 18.00,
            'domain_in_charge' => $validated['domain_in_charge'] ?? 599.00,
            'domain_com_charge'=> $validated['domain_com_charge'] ?? 999.00,
            'enable_platforms' => $request->has('enable_platforms') || !empty($platforms),
            'platforms'        => $platforms,
            'features'         => [], // Features moved to plans
            'plans'            => $plans,
            'pricing_matrix'   => $pricingMatrix,
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
            'enable_gst'       => 'nullable|boolean',
            'gst_percent'      => 'nullable|numeric|min:0|max:100',
            'domain_in_charge' => 'nullable|numeric|min:0',
            'domain_com_charge'=> 'nullable|numeric|min:0',
            // Dynamic Plan fields
            'plans'               => 'nullable|array',
            'plans.*.name'        => 'required|string|max:100',
            'plans.*.description' => 'nullable|string',
            'plans.*.delivery'    => 'nullable|string|max:100',
            'plans.*.features'    => 'nullable|string',

            // Dynamic Platform fields
            'enable_platforms'    => 'nullable|boolean',
            'platforms'           => 'nullable|array',
            'platforms.*.name'    => 'required|string|max:100',

            // Pricing Matrix
            'pricing_matrix'      => 'nullable|array',
        ]);

        $plans = $this->buildDynamicPlans($request);
        $platforms = $this->buildDynamicPlatforms($request);
        $pricingMatrix = $this->buildPricingMatrix($request, $platforms, $plans);

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
            'min_price'        => $this->calculateMinPrice($pricingMatrix),
            'icon'             => $validated['icon'] ?? 'box',
            'banner_image'     => $bannerPath,
            'delivery_timeline'=> $validated['delivery_timeline'] ?? null,
            'requirements_text'=> $validated['requirements_text'] ?? null,
            'commission_rate'  => $validated['commission_rate'] ?? null,
            'commission_type'  => $validated['commission_type'] ?? 'percentage',
            'is_popular'       => $request->boolean('is_popular'),
            'is_active'        => true,
            'requires_domain'  => $request->boolean('requires_domain'),
            'enable_gst'       => $request->boolean('enable_gst'),
            'gst_percent'      => $validated['gst_percent'] ?? 18.00,
            'domain_in_charge' => $validated['domain_in_charge'] ?? 599.00,
            'domain_com_charge'=> $validated['domain_com_charge'] ?? 999.00,
            'enable_platforms' => $request->has('enable_platforms') || !empty($platforms),
            'platforms'        => $platforms,
            'features'         => [],
            'plans'            => $plans,
            'pricing_matrix'   => $pricingMatrix,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    private function buildDynamicPlans(Request $request): array
    {
        $plans = [];
        $inputPlans = $request->input('plans', []);
        
        foreach ($inputPlans as $planData) {
            if (!empty($planData['name'])) {
                $plans[] = [
                    'name'        => $planData['name'],
                    'description' => $planData['description'] ?? '',
                    'delivery'    => $planData['delivery'] ?? '',
                    'features'    => $this->parseFeatures($planData['features'] ?? ''),
                ];
            }
        }
        return $plans;
    }

    private function buildDynamicPlatforms(Request $request): array
    {
        $platforms = [];
        $inputPlatforms = $request->input('platforms', []);
        
        foreach ($inputPlatforms as $platformData) {
            if (!empty($platformData['name'])) {
                $platforms[] = [
                    'name' => $platformData['name'],
                ];
            }
        }
        return $platforms;
    }

    private function buildPricingMatrix(Request $request, array $platforms, array $plans): array
    {
        $matrix = [];
        $inputMatrix = $request->input('pricing_matrix', []);

        foreach ($platforms as $platIndex => $platform) {
            $platformName = $platform['name'];
            $matrix[$platformName] = [];
            
            foreach ($plans as $planIndex => $plan) {
                $planName = $plan['name'];
                $price = isset($inputMatrix[$platIndex][$planIndex]) ? (float) $inputMatrix[$platIndex][$planIndex] : 0;
                $matrix[$platformName][$planName] = $price;
            }
        }
        return $matrix;
    }

    private function calculateMinPrice(array $pricingMatrix): float
    {
        $minPrice = 0;
        $prices = [];
        foreach ($pricingMatrix as $platformName => $planPrices) {
            foreach ($planPrices as $planName => $price) {
                if ($price > 0) {
                    $prices[] = $price;
                }
            }
        }
        if (!empty($prices)) {
            $minPrice = min($prices);
        }
        return $minPrice;
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
