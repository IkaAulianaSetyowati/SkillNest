<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Support\Facades\Auth;

class WebinarRegistrationController extends Controller
{
    // 1. Proses saat user klik "Daftar Webinar"
    public function store(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);
        $user = Auth::user();

        // Cek apakah user sudah terdaftar sebelumnya
        $existing = WebinarRegistration::where('user_id', $user->id)
                                       ->where('webinar_id', $webinar->id)
                                       ->first();
        if ($existing) {
            if ($existing->status === 'approved') {
                return redirect()->route('tickets.index')->with('error', 'Anda sudah terdaftar di webinar ini.');
            }
            // Jika sudah mendaftar tapi berbayar dan statusnya pending, arahkan langsung ke metode bayar
            return redirect()->route('webinars.payment.method', $existing->id);
        }

        $harga = floatval($webinar->harga);
        $tipe = strtolower(trim($webinar->tipe));
        $isFree = ($harga <= 0 || $tipe === 'gratis');

        // Buat data registrasi baru
        $registration = WebinarRegistration::create([
            'user_id' => $user->id,
            'webinar_id' => $webinar->id,
            'status' => $isFree ? 'approved' : 'pending', 
        ]);

        // JIKA GRATIS -> Langsung approved & ke tiket
        if ($isFree) {
            return redirect()->route('tickets.index')->with('success', 'Pendaftaran berhasil! E-ticket telah dikirim ke akun Anda.');
        }

        // JIKA BERBAYAR -> Arahkan ke halaman pilih metode pembayaran berdasarkan ID pendaftaran
        return redirect()->route('webinars.payment.method', $registration->id);
    }

    // 2. Menampilkan form pilih metode pembayaran
    public function showPaymentMethod($registrationId)
    {
        $registration = WebinarRegistration::with('webinar')->findOrFail($registrationId);
        return view('webinars.payment-method', compact('registration'));
    }

    // 3. Simpan pilihan metode pembayaran lalu lempar ke form upload bukti
    public function storePaymentMethod(Request $request, $registrationId)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $registration = WebinarRegistration::findOrFail($registrationId);
        $registration->update([
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('webinars.upload.form', $registration->id);
    }

    // 4. Menampilkan form upload bukti bayar
    public function showUploadForm($registrationId)
    {
        $registration = WebinarRegistration::with('webinar')->findOrFail($registrationId);
        return view('webinars.upload-proof', compact('registration'));
    }

    // 5. Proses simpan bukti bayar
    public function submitUpload(Request $request, $registrationId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $registration = WebinarRegistration::findOrFail($registrationId);
        
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $registration->update([
            'payment_proof' => $path,
            'status' => 'pending', 
        ]);

        return redirect()->route('webinars.waiting', $registration->id);
    }

    // 6. Halaman menunggu verifikasi organizer
    public function waiting($registrationId)
    {
        $registration = WebinarRegistration::with('webinar')->findOrFail($registrationId);
        return view('webinars.waiting', compact('registration'));
    }

    // 7. Menampilkan E-Ticket jika sudah di-approve
    public function eTicket($registrationId)
    {
        $registration = WebinarRegistration::with('webinar')->findOrFail($registrationId);
        
        if ($registration->status !== 'approved') {
            return redirect()->route('webinars.waiting', $registration->id)->with('error', 'Pembayaran Anda belum disetujui.');
        }

        return view('webinars.e-ticket', compact('registration'));
    }

    // 8. Menampilkan daftar tiket milik user yang login
    public function myTickets(Request $request)
    {
        $registrations = WebinarRegistration::with('webinar')
                            ->where('user_id', $request->user()->id)
                            ->where('status', 'approved')
                            ->latest()
                            ->get();

        return view('user.tickets', compact('registrations'));
    }
}