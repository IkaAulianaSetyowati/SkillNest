<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil statistik
        $totalUsers = User::count();
        $totalOrganizers = User::where('role', 'organizer')->count();
        $pendingVerifications = User::where('role', 'organizer')
            ->whereNull('email_verified_at') // atau kolom status verifikasi organizer kamu
            ->count();

        // Query pengguna dengan pencarian
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('admin.dashboard', compact('totalUsers', 'totalOrganizers', 'pendingVerifications', 'users', 'search'));
    }
}