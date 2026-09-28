<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Webinar;
use App\Models\WebinarMaterial;
use App\Models\Registration;
use App\Models\Certificate;
use App\Models\Review;
use App\Models\Discussion;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\Bookmark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin, Organizer, Participant)
        $admin = User::create([
            'name' => 'Admin SkillNest',
            'email' => 'admin@skillnest.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567890',
            'role' => 'admin',
            'bio' => 'Platform Administrator for SkillNest.',
        ]);

        $organizer = User::create([
            'name' => 'Tech Academy Org',
            'email' => 'organizer@skillnest.com',
            'password' => Hash::make('password'),
            'phone_number' => '081298765432',
            'role' => 'organizer',
            'bio' => 'Lembaga pelatihan teknologi dan bisnis terpercaya.',
            'organization_name' => 'Tech Academy Indonesia',
        ]);

        $participant = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '085712345678',
            'role' => 'participant',
            'bio' => 'Web Developer Enthusiast.',
        ]);

        // 2. Seed Categories
        $catTech = Category::create([
            'name' => 'Technology & Code',
            'slug' => 'technology-code',
            'icon' => 'code-bracket',
            'description' => 'Web development, AI, Cloud Computing, & DevOps',
        ]);

        $catDesign = Category::create([
            'name' => 'UI/UX & Design',
            'slug' => 'ui-ux-design',
            'icon' => 'paint-brush',
            'description' => 'Figma, Design System, Product Design, & Prototyping',
        ]);

        $catBiz = Category::create([
            'name' => 'Business & Marketing',
            'slug' => 'business-marketing',
            'icon' => 'chart-bar',
            'description' => 'Digital Marketing, Startup Strategy, & Leadership',
        ]);

        // 3. Seed Webinars
        $webinar1 = Webinar::create([
            'organizer_id' => $organizer->id,
            'category_id' => $catTech->id,
            'title' => 'Mastering Laravel 11 & Inertia.js Ecosystem',
            'slug' => Str::slug('Mastering Laravel 11 & Inertia.js Ecosystem'),
            'summary' => 'Pelajari arsitektur modern full-stack web development dengan Laravel 11.',
            'description' => 'Dalam webinar ini kamu akan mempelajari pembuatan aplikasi modern menggunakan Laravel 11, Inertia.js, dan Tailwind CSS dari dasar hingga siap deploy.',
            'banner' => 'webinars/banners/laravel11.jpg',
            'type' => 'online',
            'location' => 'https://zoom.us/j/1234567890',
            'speaker_name' => 'Rian Pratama',
            'speaker_title' => 'Senior Backend Engineer',
            'speaker_company' => 'Tech Corp',
            'date' => '2026-10-15',
            'start_time' => '19:00:00',
            'end_time' => '21:00:00',
            'price' => 150000.00,
            'quota' => 100,
            'status' => 'published',
            'is_featured' => true,
            'benefit' => 'E-Certificate, Source Code, Rekaman Video HD',
            'rating_cache' => 4.8,
            'total_reviews' => 1,
        ]);

        $webinar2 = Webinar::create([
            'organizer_id' => $organizer->id,
            'category_id' => $catDesign->id,
            'title' => 'Building Design System with Figma from Scratch',
            'slug' => Str::slug('Building Design System with Figma from Scratch'),
            'summary' => 'Panduan praktis membuat design system yang scalable di Figma.',
            'description' => 'Pelajari teknik profesional dalam menyusun component library, design tokens, dan auto-layout untuk efisiensi tim design.',
            'banner' => 'webinars/banners/figma.jpg',
            'type' => 'online',
            'location' => 'https://meet.google.com/abc-defg-hij',
            'speaker_name' => 'Siti Nurhaliza',
            'speaker_title' => 'Lead Product Designer',
            'speaker_company' => 'DesignStudio',
            'date' => '2026-09-01',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'price' => 0.00, // Gratis
            'quota' => 200,
            'status' => 'completed',
            'is_featured' => true,
            'benefit' => 'E-Certificate & Access Rekaman',
            'rating_cache' => 5.0,
            'total_reviews' => 1,
        ]);

        // 4. Seed Webinar Materials (Termasuk Link Video Rekaman)
        WebinarMaterial::create([
            'webinar_id' => $webinar2->id,
            'title' => 'Rekaman Sesi Live - Figma Design System',
            'type' => 'video',
            'external_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'is_downloadable' => false,
        ]);

        WebinarMaterial::create([
            'webinar_id' => $webinar2->id,
            'title' => 'Slide Presentasi Figma Masterclass (PDF)',
            'type' => 'file',
            'file_path' => 'materials/figma-masterclass.pdf',
            'is_downloadable' => true,
        ]);

        // 5. Seed Registration & Payment
        $reg = Registration::create([
            'registration_code' => 'REG-' . strtoupper(Str::random(8)),
            'user_id' => $participant->id,
            'webinar_id' => $webinar2->id,
            'amount' => 0.00,
            'status' => 'approved',
            'payment_status' => 'paid',
            'attended_at' => now(),
        ]);

        // 6. Seed Certificate
        Certificate::create([
            'registration_id' => $reg->id,
            'certificate_number' => 'CERT/SKILLNEST/2026/09/0001',
            'file_path' => 'certificates/CERT-0001.pdf',
            'issued_at' => now(),
        ]);

        // 7. Seed Review
        Review::create([
            'user_id' => $participant->id,
            'webinar_id' => $webinar2->id,
            'registration_id' => $reg->id,
            'rating' => 5,
            'comment' => 'Materi sangat berbobot dan cara penyampaian pemateri sangat jelas!',
        ]);

        // 8. Seed Webinar Discussion (Opsi 1: Forum Eksklusif Webinar)
        Discussion::create([
            'webinar_id' => $webinar2->id,
            'user_id' => $participant->id,
            'message' => 'Apakah pemateri menyediakkan plugin Figma rekomendasinya?',
        ]);

        // 9. Seed Community (Opsi 2: Wadah Komunitas Umum)
        $community = Community::create([
            'name' => 'Laravel Developer Indonesia',
            'slug' => 'laravel-developer-indonesia',
            'category_id' => $catTech->id,
            'created_by' => $organizer->id,
            'description' => 'Komunitas tempat berbagi ilmu, tips, dan lowongan kerja Laravel.',
            'icon' => 'communities/icons/laravel.png',
        ]);

        // 10. Seed Community Member
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => $participant->id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        // 11. Seed Community Post (Thread Berbagi Pengalaman)
        CommunityPost::create([
            'community_id' => $community->id,
            'user_id' => $participant->id,
            'title' => 'Pengalaman Migrasi ke Laravel 11 dari Laravel 10',
            'content' => 'Sangat menghemat waktu karena konfigurasi middleware dan routing sekarang lebih ringkas!',
        ]);

        // 12. Seed Bookmark
        Bookmark::create([
            'user_id' => $participant->id,
            'webinar_id' => $webinar1->id,
        ]);
    }
}