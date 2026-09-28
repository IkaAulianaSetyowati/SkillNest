<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Webinar;

class WebinarSeeder extends Seeder
{
    public function run(): void
    {
        Webinar::create([
            'title' => 'Dasar-Dasar Bahasa Jepang Praktis untuk Percakapan Harian',
            'category' => 'Pendidikan & Karir',
            'speaker' => 'Kenji Tanaka',
            'date_time' => '2026-10-24 18:30:00',
            'price' => 75000,
            'banner' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80'
        ]);

        Webinar::create([
            'title' => 'Seni Fotografi Ponsel: Menghasilkan Foto Profesional dari HP',
            'category' => 'Desain & UI/UX',
            'speaker' => 'Eko Prasetyo',
            'date_time' => '2026-10-19 19:00:00',
            'price' => 0,
            'banner' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80'
        ]);

        Webinar::create([
            'title' => 'Nutrisi Sehat & Meal Prep Praktis untuk Pekerja Sibuk',
            'category' => 'Pengembangan Diri',
            'speaker' => 'Dinda Kirana, S.Gz',
            'date_time' => '2026-10-25 10:00:00',
            'price' => 45000,
            'banner' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80'
        ]);

        Webinar::create([
            'title' => 'Work-Life Balance & Mental Health Management',
            'category' => 'Pengembangan Diri',
            'speaker' => 'dr. Ilona Amalia',
            'date_time' => '2026-10-17 19:00:00',
            'price' => 0,
            'banner' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=600&q=80'
        ]);
    }
}