<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\Service;
use Illuminate\Support\Str;

class PremiumDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Banners
        $banners = [
            [
                'title' => 'Launch Your E-Commerce Empire Today',
                'image_path' => 'https://images.unsplash.com/photo-1556742049-0a67d55febc2?auto=format&fit=crop&w=1200&q=80',
                'link' => '/services/custom-ecommerce-website-development',
                'is_active' => true,
            ],
            [
                'title' => 'Master Digital Growth with Google & FB Ads',
                'image_path' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'link' => '/services',
                'is_active' => true,
            ],
            [
                'title' => 'Transform Ideas into High-End Flutter Apps',
                'image_path' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=1200&q=80',
                'link' => '/services/premium-mobile-app-development',
                'is_active' => true,
            ],
            [
                'title' => 'Refer & Earn Up to 30% Instant Commission',
                'image_path' => 'https://images.unsplash.com/photo-1552581234-2616094ec49a?auto=format&fit=crop&w=1200&q=80',
                'link' => '/register',
                'is_active' => true,
            ],
        ];

        foreach ($banners as $b) {
            Banner::firstOrCreate(['title' => $b['title']], $b);
        }

        // 2. Seed Services
        $services = [
            [
                'name' => 'E-commerce Website Design & Development',
                'slug' => 'e-commerce-website-design-development',
                'category' => 'Web Development',
                'short_description' => 'Fully custom E-commerce online store designed to scale your business and boost conversions.',
                'description' => 'Launch a premium E-commerce platform. Includes product catalogs, custom cart system, payment gateway integration, secure checkout, and mobile responsiveness.',
                'min_price' => 15000.00,
                'icon' => 'shopping-cart',
                'delivery_timeline' => '15 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a129094a01cd.jpg',
            ],
            [
                'name' => 'Informative Website Design & Development',
                'slug' => 'informative-website-design-development',
                'category' => 'Web Development',
                'short_description' => 'Professional, highly responsive corporate websites to showcase your brand, services, and capture leads.',
                'description' => 'Establish a professional web presence. Includes home page, about page, services lists, contact forms, interactive features, and full lead-capture setups.',
                'min_price' => 8000.00,
                'icon' => 'globe',
                'delivery_timeline' => '7 Days',
                'is_popular' => false,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => null,
            ],
            [
                'name' => 'E-commerce Mobile App Development',
                'slug' => 'e-commerce-mobile-app-development',
                'category' => 'App Development',
                'short_description' => 'Feature-rich custom mobile shopping application for iOS & Android to retain customers and drive mobile sales.',
                'description' => 'Convert more buyers on mobile. Fully native iOS & Android shopping applications with real-time stock sync, push notifications, secure profile dashboards, and quick payments.',
                'min_price' => 25000.00,
                'icon' => 'smartphone',
                'delivery_timeline' => '20 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a1290dcb85f9.jpg',
            ],
            [
                'name' => 'Grocery Mobile App Development',
                'slug' => 'grocery-mobile-app-development',
                'category' => 'App Development',
                'short_description' => 'Bespoke on-demand grocery delivery and ordering app with real-time stock management and order tracking.',
                'description' => 'Launch a powerful grocery delivery app. Includes vendor panel, real-time inventory management, slots booking, delivery boy tracking, and multiple secure checkout gateways.',
                'min_price' => 22000.00,
                'icon' => 'shopping-bag',
                'delivery_timeline' => '25 Days',
                'is_popular' => false,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a1290dcb85f9.jpg',
            ],
            [
                'name' => 'Food Delivery Mobile App Development',
                'slug' => 'food-delivery-mobile-app-development',
                'category' => 'App Development',
                'short_description' => 'Feature-loaded online food delivery app with restaurant portal, driver tracking, and instant payments.',
                'description' => 'Launch your own food ordering app. Dynamic restaurant menu systems, driver tracking, discount coupons, push notifications, and customizable restaurant portals.',
                'min_price' => 24000.00,
                'icon' => 'truck',
                'delivery_timeline' => '30 Days',
                'is_popular' => false,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a1290dcb85f9.jpg',
            ],
            [
                'name' => 'Meta Ads',
                'slug' => 'meta-ads',
                'category' => 'Digital Marketing',
                'short_description' => 'High-ROAS Facebook & Instagram campaigns, custom funnel tracking, and automated retargeting to maximize sales.',
                'description' => 'Stop wasting ad spend. We create high-converting ad copies, target ready-to-buy audiences, design custom landing page parameters, and optimize campaigns for high ROAS.',
                'min_price' => 12000.00,
                'icon' => 'target',
                'delivery_timeline' => '7 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a1291218eb85.jpg',
            ],
            [
                'name' => 'Google Ads',
                'slug' => 'google-ads',
                'category' => 'Digital Marketing',
                'short_description' => 'Target high-intent customers exactly when they search for your services with optimized Google Search & Display Ads.',
                'description' => 'Capture active buyers. Google Search ads, Performance Max (PMax) setups, dynamic search keywords, and competitor tracking campaigns designed to win high-quality leads.',
                'min_price' => 12000.00,
                'icon' => 'search',
                'delivery_timeline' => '7 Days',
                'is_popular' => false,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a1291218eb85gad.jpg',
            ],
            [
                'name' => 'SEO (Search Engine Optimization)',
                'slug' => 'seo-search-engine-optimization',
                'category' => 'Digital Marketing',
                'short_description' => 'Dominate organic search result pages, optimize content, build authority, and drive targeted web traffic 24/7.',
                'description' => 'Rank #1 on Google organically. Includes full technical SEO audit, high-volume keyword optimization, content outlines, schema markups, and high-DA authority backlink creation.',
                'min_price' => 10000.00,
                'icon' => 'trending-up',
                'delivery_timeline' => '30 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a128f214c70d.jpg',
            ],
            [
                'name' => 'Reels & Video Editing',
                'slug' => 'reels-video-editing',
                'category' => 'Video Editing',
                'short_description' => 'Capture attention instantly on YouTube, Instagram, and TikTok with professional cinematic cuts and trendy graphics.',
                'description' => 'Create viral hooks in 3 seconds. High-end video cuts, engaging dynamic subtitles, custom sound design, color grading, motion graphics, and premium transition effects.',
                'min_price' => 5000.00,
                'icon' => 'video',
                'delivery_timeline' => '5 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 20.00,
                'commission_type' => 'percentage',
                'banner_image' => 'services/6a128f8f7413e.jpg',
            ],
        ];

        // Deactivate other/old services so they do not clutter the lists
        Service::query()->update(['is_active' => false]);

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
