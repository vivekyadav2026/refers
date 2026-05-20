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
                'name' => 'Advanced SEO & Google Search Ranking',
                'slug' => Str::slug('Advanced SEO & Google Search Ranking'),
                'category' => 'Digital Marketing',
                'short_description' => 'Dominate Google search results with our technical SEO, keyword optimization, and high-DA backlink building.',
                'description' => 'Rank your business at the top of Google. We handle on-page optimization, technical site audits, schema markup, and premium authoritative link building to drive organic traffic.',
                'min_price' => 18000.00,
                'icon' => 'trending-up',
                'delivery_timeline' => '30 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
            ],
            [
                'name' => 'Facebook & Instagram Viral Ads Mastery',
                'slug' => Str::slug('Facebook & Instagram Viral Ads Mastery'),
                'category' => 'Digital Marketing',
                'short_description' => 'High-converting ad campaigns optimized for maximum ROAS, lead generation, and direct sales.',
                'description' => 'Stop wasting ad spend. We create compelling ad creatives, set up precise audience targeting, custom retargeting funnels, and manage end-to-end Meta ad campaigns.',
                'min_price' => 20000.00,
                'icon' => 'target',
                'delivery_timeline' => '7 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
            ],
            [
                'name' => 'Cinematic Video Editing & Viral Reels',
                'slug' => Str::slug('Cinematic Video Editing & Viral Reels'),
                'category' => 'Video Editing',
                'short_description' => 'Engaging short-form and long-form video editing with motion graphics, captions, and sound design.',
                'description' => 'Capture attention in the first 3 seconds. Perfect for YouTube, Instagram Reels, and TikTok. We include dynamic subtitles, sound FX, color grading, and smooth transitions.',
                'min_price' => 15000.00,
                'icon' => 'video',
                'delivery_timeline' => '5 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 20.00,
                'commission_type' => 'percentage',
            ],
            [
                'name' => 'UI/UX Brand Identity & Figma Design',
                'slug' => Str::slug('UI/UX Brand Identity & Figma Design'),
                'category' => 'Design & Branding',
                'short_description' => 'Complete brand overhaul including logo, design system, typography, and interactive Figma prototypes.',
                'description' => 'Elevate your brand perception with world-class design. We craft bespoke brand guidelines, responsive web layouts, and interactive mobile app screens in Figma.',
                'min_price' => 30000.00,
                'icon' => 'palette',
                'delivery_timeline' => '10 Days',
                'is_popular' => false,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
            ],
            [
                'name' => 'AI Chatbot & Workflow Automation',
                'slug' => Str::slug('AI Chatbot & Workflow Automation'),
                'category' => 'AI & Automation',
                'short_description' => 'Custom ChatGPT-powered support agents and WhatsApp bots to automate 90% of customer inquiries.',
                'description' => 'Deploy intelligent 24/7 AI assistants. Trained on your specific company data to answer support questions, book appointments, and capture leads automatically on WhatsApp or website.',
                'min_price' => 35000.00,
                'icon' => 'bot',
                'delivery_timeline' => '14 Days',
                'is_popular' => true,
                'is_active' => true,
                'commission_rate' => 15.00,
                'commission_type' => 'percentage',
            ]
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
