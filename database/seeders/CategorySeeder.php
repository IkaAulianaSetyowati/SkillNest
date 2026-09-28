<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Digital Marketing',
                'name_en' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'icon' => 'fas fa-bullhorn',
                'bg_color' => 'bg-blue-50 text-blue-600',
                'description' => 'Strategi pemasaran digital, SEO, SEM, dan manajemen media sosial.',
                'description_en' => 'Digital marketing strategy, SEO, SEM, and social media management.',
            ],
            [
                'name' => 'Teknologi & Coding',
                'name_en' => 'Tech & Coding',
                'slug' => 'teknologi-coding',
                'icon' => 'fas fa-code',
                'bg_color' => 'bg-indigo-50 text-indigo-600',
                'description' => 'Pengembangan web, aplikasi mobile, cloud computing, dan DevOps.',
                'description_en' => 'Web development, mobile apps, cloud computing, and DevOps.',
            ],
            [
                'name' => 'Pengembangan Diri',
                'name_en' => 'Personal Development',
                'slug' => 'pengembangan-diri',
                'icon' => 'fas fa-user',
                'bg_color' => 'bg-emerald-50 text-emerald-600',
                'description' => 'Public speaking, kepemimpinan, manajemen waktu, dan komunikasi.',
                'description_en' => 'Public speaking, leadership, time management, and communication.',
            ],
            [
                'name' => 'Bisnis & Keuangan',
                'name_en' => 'Business & Finance',
                'slug' => 'bisnis-keuangan',
                'icon' => 'fas fa-chart-line',
                'bg_color' => 'bg-amber-50 text-amber-600',
                'description' => 'Kewirausahaan, analisis keuangan, investasi, dan strategi bisnis.',
                'description_en' => 'Entrepreneurship, financial analysis, investment, and business strategy.',
            ],
            [
                'name' => 'Desain & UI/UX',
                'name_en' => 'Design & UI/UX',
                'slug' => 'desain-uiux',
                'icon' => 'fas fa-palette',
                'bg_color' => 'bg-purple-50 text-purple-600',
                'description' => 'Desain grafis, prototyping, UI/UX research, dan produk desain.',
                'description_en' => 'Graphic design, prototyping, UI/UX research, and product design.',
            ],
            [
                'name' => 'Pendidikan & Karir',
                'name_en' => 'Education & Career',
                'slug' => 'pendidikan-karir',
                'icon' => 'fas fa-graduation-cap',
                'bg_color' => 'bg-rose-50 text-rose-600',
                'description' => 'Persiapan beasiswa, optimasi CV, wawancara kerja, dan jalur karir.',
                'description_en' => 'Scholarship prep, CV optimization, job interviews, and career paths.',
            ],
            [
                'name' => 'Lainnya',
                'name_en' => 'Others',
                'slug' => 'lainnya',
                'icon' => 'fas fa-cubes',
                'bg_color' => 'bg-teal-50 text-teal-600',
                'description' => 'Fotografi, bahasa asing, hobi, dan topik menarik lainnya.',
                'description_en' => 'Photography, foreign languages, hobbies, and other interesting topics.',
            ],
        ];

        foreach ($data as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}