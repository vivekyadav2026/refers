<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class PackageSeeder extends Seeder
{
    public function run()
    {
        // SEO Packages
        $seoService = Service::where('name', 'like', '%SEO%')->first();
        if ($seoService) {
            $seoService->update([
                'plans' => [
                    'Starter'  => ['price' => 1499, 'description' => 'Basic SEO package', 'delivery' => '1 Month', 'features' => ['On-Page Optimization', 'Keyword Research'], 'emoji' => '🌱'],
                    'Standard' => ['price' => 6999, 'description' => 'Standard SEO package', 'delivery' => '1 Month', 'features' => ['On-Page + Off-Page SEO', 'Content Strategy'], 'emoji' => '⭐'],
                    'Premium'  => ['price' => 12999, 'description' => 'Premium SEO package', 'delivery' => '1 Month', 'features' => ['Full Technical SEO', 'Premium Backlinks', 'Monthly Audit'], 'emoji' => '👑'],
                ]
            ]);
        }

        // Meta Ads Packages
        $metaAdsService = Service::where('name', 'like', '%Meta%')->orWhere('name', 'like', '%Facebook%')->first();
        if ($metaAdsService) {
            $metaAdsService->update([
                'plans' => [
                    '1000/Day' => ['price' => 1000, 'description' => 'Spend ₹1000 per day', 'delivery' => 'Daily', 'features' => ['Ad Setup (₹500 Charge)', 'Audience Targeting'], 'emoji' => '🚀'],
                    '2000/Day' => ['price' => 2000, 'description' => 'Spend ₹2000 per day', 'delivery' => 'Daily', 'features' => ['Advanced Targeting', 'A/B Testing'], 'emoji' => '🔥'],
                    '5000/Day' => ['price' => 5000, 'description' => 'Spend ₹5000 per day', 'delivery' => 'Daily', 'features' => ['Scaling Strategy', 'Retargeting'], 'emoji' => '⚡'],
                ]
            ]);
        }

        // Google Ads Packages
        $googleAdsService = Service::where('name', 'like', '%Google Ads%')->first();
        if ($googleAdsService) {
            $googleAdsService->update([
                'plans' => [
                    '1500/Day' => ['price' => 1500, 'description' => 'Spend ₹1500 per day', 'delivery' => 'Daily', 'features' => ['Search Network', 'Setup Charge (₹500)'], 'emoji' => '🎯'],
                    '3000/Day' => ['price' => 3000, 'description' => 'Spend ₹3000 per day', 'delivery' => 'Daily', 'features' => ['Display Network', 'Conversion Tracking'], 'emoji' => '📈'],
                    '6000/Day' => ['price' => 6000, 'description' => 'Spend ₹6000 per day', 'delivery' => 'Daily', 'features' => ['Performance Max', 'YouTube Ads'], 'emoji' => '💎'],
                ]
            ]);
        }

        // Video Editing Packages
        $videoService = Service::where('name', 'like', '%Video%')->orWhere('name', 'like', '%Reel%')->first();
        if ($videoService) {
            $videoService->update([
                'plans' => [
                    'Normal'  => ['price' => 299, 'description' => 'Normal editing for reels/shorts', 'delivery' => '24-48 Hours', 'features' => ['Basic Cuts', 'Background Music'], 'emoji' => '✂️'],
                    'Advance' => ['price' => 399, 'description' => 'Advanced editing for reels/shorts', 'delivery' => '24-48 Hours', 'features' => ['Motion Graphics', 'Color Grading', 'Captions'], 'emoji' => '🎬'],
                    'Per Minute'    => ['price' => 0, 'description' => 'Custom pricing based on video length', 'delivery' => 'Custom', 'features' => ['Long Form Video', 'Custom Requirements'], 'emoji' => '⏱️'],
                ]
            ]);
        }
    }
}
