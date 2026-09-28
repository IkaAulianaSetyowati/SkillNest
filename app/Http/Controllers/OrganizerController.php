<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        // Mengambil webinar milik user login (atau semua jika belum diset relasinya)
        $webinars = Webinar::latest()->get();

        return view('organizer.dashboard', compact('webinars'));
    }
}