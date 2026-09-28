<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Webinar;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Daftar peserta yang menunggu verifikasi, khusus webinar milik organizer yang login.
     */
    public function index(Request $request)
    {
        $organizerId = auth()->id();

        $registrations = Registration::whereHas('webinar', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->with(['user', 'webinar'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        return view('organizer.registrations.index', compact('registrations'));
    }

    public function approve(Registration $registration)
    {
        $this->authorizeOrganizer($registration);

        $registration->update([
            'status' => 'approved',
            'payment_status' => 'paid',
        ]);

        return back()->with('success', 'Pendaftaran peserta berhasil disetujui.');
    }

    public function reject(Registration $registration)
    {
        $this->authorizeOrganizer($registration);

        $registration->update([
            'status' => 'rejected',
            'payment_status' => 'failed',
        ]);

        // Kembalikan kuota karena ditolak
        $registration->webinar->decrement('terisi');

        return back()->with('success', 'Pendaftaran peserta ditolak.');
    }

    private function authorizeOrganizer(Registration $registration)
    {
        $registration->load('webinar');
        if ($registration->webinar->organizer_id !== auth()->id()) {
            abort(403);
        }
    }
}