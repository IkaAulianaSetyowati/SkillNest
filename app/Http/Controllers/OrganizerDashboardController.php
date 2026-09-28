<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizerDashboardController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Kamu bisa menambahkan variabel data statistik webinar di sini nantinya
        return view('organizer.dashboard', compact('user'));
    }
}