<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::truncate();

        $banners = [
            [
                'title'      => 'Refer & Earn Up To 30% Commission',
                'image_path' => 'banners/banner_refer_earn.png',
                'link'       => '/partner/apply',
                'is_active'  => true,
            ],
            [
                'title'      => 'Premium Web & App Development Services',
                'image_path' => 'banners/banner_web_app_dev.png',
                'link'       => '/services',
                'is_active'  => true,
            ],
            [
                'title'      => 'Grow Your Business With Digital Marketing',
                'image_path' => 'banners/banner_digital_marketing.png',
                'link'       => '/services',
                'is_active'  => true,
            ],
            [
                'title'      => 'Join Our Partner Network & Start Earning',
                'image_path' => 'banners/banner_partner_earn.png',
                'link'       => '/partner/apply',
                'is_active'  => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        $this->command->info('✅ 4 banners seeded successfully!');
    }
}
