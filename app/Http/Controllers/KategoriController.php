<?php

namespace App\Http\Controllers;

use App\Models\Category;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('webinars')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $webinars = $category->webinars()->paginate(9);

        return view('categories.show', compact('category', 'webinars'));
    }
}