<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use Illuminate\Support\Str;

class BusinessCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'IT & Software Services' => [
                'Web Development',
                'Mobile App Development',
                'Custom Software Development',
                'UI/UX Design',
                'Cybersecurity Services',
                'Cloud & DevOps Consulting'
            ],
            'Digital Marketing' => [
                'Search Engine Optimization (SEO)',
                'Social Media Marketing (SMM)',
                'Pay-Per-Click Advertising (PPC)',
                'Content Writing & Copywriting',
                'Email Marketing Campaign',
                'Influencer Marketing'
            ],
            'Financial & Tax Advisory' => [
                'GST Filing & Registration',
                'Income Tax Returns (ITR)',
                'Company Incorporation',
                'Bookkeeping & Accounting',
                'Corporate Financial Planning',
                'Audit & Compliance Support'
            ],
            'Creative & Multimedia' => [
                'Cinematic Video Editing',
                'Graphic Design & Branding',
                '3D Modeling & Animation',
                'Commercial Photography',
                'Voiceover & Audio Production'
            ],
            'Education & Training' => [
                'Online Professional Courses',
                'Corporate Training Programs',
                'Career Counselling Sessions',
                'Language Learning Programs'
            ]
        ];

        foreach ($data as $parentName => $subcategories) {
            $parent = BusinessCategory::firstOrCreate(
                ['name' => $parentName],
                [
                    'slug' => Str::slug($parentName),
                    'parent_id' => null,
                    'is_active' => true
                ]
            );

            foreach ($subcategories as $subName) {
                BusinessCategory::firstOrCreate(
                    ['name' => $subName],
                    [
                        'slug' => Str::slug($subName),
                        'parent_id' => $parent->id,
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
