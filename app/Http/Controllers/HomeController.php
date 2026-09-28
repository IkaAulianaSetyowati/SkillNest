<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredWebinars = Webinar::orderBy('tanggal', 'asc')->take(4)->get();
        return view('home', compact('featuredWebinars'));
    }

    // Menampilkan daftar semua kategori
    public function categoriesIndex()
    {
        $categories = [
            'Digital Marketing',
            'Teknologi & Coding',
            'Pengembangan Diri',
            'Bisnis & Keuangan',
            'Desain & UI/UX',
            'Pendidikan & Karir',
            'Lainnya'
        ];

        return view('categories.index', compact('categories'));
    }

    // Menampilkan webinar berdasarkan kategori tertentu
    public function categoryShow($category)
    {
        // Ubah format URL slug (contoh: "digital-marketing" menjadi "Digital Marketing")
        // Ini memastikan pencarian database cocok meskipun URL menggunakan tanda hubung (-)
        $decodedCategory = ucwords(str_replace('-', ' ', urldecode($category)));

        // Ambil webinar yang kategorinya cocok dari database
        $webinars = Webinar::where('category', 'LIKE', '%' . $decodedCategory . '%')->get();

        return view('categories.show', compact('decodedCategory', 'webinars'));
    }

    public function community()
    {
        return view('pages.community');
    }

    public function organizer()
    {
        return view('pages.organizer');
    }
}