<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\Category;
use App\Models\Registration;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    /**
     * Menampilkan daftar semua webinar dari database.
     */
    public function index(Request $request)
    {
        // 1. Ambil data webinar dari database beserta relasinya (eager loading untuk performa optimal)
        $query = Webinar::with(['kategori', 'organizer'])->latest();

        // 2. Fitur pencarian jika ada query parameter 'search' dari form
        if ($request->has('search') && !empty($request->input('search'))) {
            $keyword = $request->input('search');
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('speaker', 'like', "%{$keyword}%");
            });
        }

        $webinars = $query->get();

        // 3. Transformasi data agar sesuai dengan tampilan view (banner, speaker, tanggal, harga, dll)
        $webinars->transform(function ($webinar) {
            // Menyesuaikan kolom judul (menggunakan 'judul' jika ada, atau fallback ke 'title')
            $webinar->title = $webinar->judul ?? ($webinar->title ?? '');

            // Menyesuaikan gambar banner (mendukung asset storage atau path langsung)
            $bannerPath = $webinar->banner ?? ($webinar->image ?? '');
            if (!empty($bannerPath)) {
                $webinar->image = filter_var($bannerPath, FILTER_VALIDATE_URL) ? $bannerPath : asset($bannerPath);
            } else {
                $webinar->image = asset('images/default-banner.png');
            }

            // Menyesuaikan nama pembicara/narasumber dari kolom database
            $webinar->speaker = $webinar->speaker ?? ($webinar->organizer->nama ?? ($webinar->organizer->name ?? 'Narasumber'));

            // Menyesuaikan format tanggal dan waktu dari database
            if (!empty($webinar->tanggal)) {
                $ts = strtotime($webinar->tanggal);
                $months = [
                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                $day = date('d', $ts);
                $monthNum = (int)date('m', $ts);
                $year = date('Y', $ts);
                $time = date('H:i', $ts);
                
                $monthName = $months[$monthNum] ?? date('F', $ts);
                $webinar->formatted_date = "$day $monthName $year • $time WIB";
            } else {
                $webinar->formatted_date = 'Jadwal segera';
            }

            // Menyesuaikan tipe dan harga
            $actualPrice = $webinar->harga ?? ($webinar->price ?? 0);
            $webinar->is_free = (strtolower($webinar->tipe) == 'gratis' || $actualPrice == 0);
            $webinar->formatted_price = $webinar->is_free ? 'Gratis' : 'Rp ' . number_format($actualPrice, 0, ',', '.');
            $webinar->price = $actualPrice; // pastikan nilai price numerik terbaca view
            $webinar->type = $webinar->is_free ? 'free' : 'paid';

            return $webinar;
        });

        // 4. Ambil daftar kategori unik dari tabel kategori atau dari data webinar yang tersedia
        $categories = Category::pluck('name')->toArray();
        if (empty($categories)) {
            $categories = Webinar::with('kategori')->get()->pluck('category')->unique()->filter()->values();
        }

        return view('webinars.index', compact('webinars', 'categories'));
    }

    /**
     * Menampilkan detail webinar berdasarkan ID dari database.
     */
    public function show($id)
    {
        // Cari data webinar di database beserta relasinya, atau abort 404 jika tidak ditemukan
        $webinar = Webinar::with(['kategori', 'organizer'])->findOrFail($id);

        // Tambahan properti pembantu agar kompatibel penuh dengan tampilan view detail Anda
        $webinar->title = $webinar->judul ?? ($webinar->title ?? '');
        $webinar->speaker = $webinar->speaker ?? ($webinar->organizer->nama ?? ($webinar->organizer->name ?? 'Narasumber'));
        
        $actualPrice = $webinar->harga ?? ($webinar->price ?? 0);
        $webinar->is_free = (strtolower($webinar->tipe) == 'gratis' || $actualPrice == 0);
        $webinar->price = $actualPrice;

        // Waktu diambil dari kolom 'waktu' (bukan dari 'tanggal', karena 'tanggal' tidak menyimpan jam)
        $webinar->time = !empty($webinar->getRawOriginal('waktu'))
            ? \Carbon\Carbon::parse($webinar->getRawOriginal('waktu'))->format('H:i') . ' WIB'
            : '19:00 WIB';

        // Banner: samakan cara resolve path dengan halaman index (pakai prefix storage/)
        $bannerPath = $webinar->getRawOriginal('banner') ?? null;
        $webinar->image = !empty($bannerPath)
            ? (filter_var($bannerPath, FILTER_VALIDATE_URL) ? $bannerPath : asset('storage/' . $bannerPath))
            : asset('images/default-banner.png');

        // Field yang dipakai view detail tapi belum ada di data asli:
        $webinar->date = $webinar->tanggal ?? now(); // dipakai Carbon::parse() di view
        $webinar->category = $webinar->kategori->name ?? 'Umum'; // dipakai badge kategori & gradient fallback
        $webinar->description = $webinar->getRawOriginal('description') ?? 'Belum ada deskripsi untuk webinar ini.';

        // Cek status pendaftaran user yang sedang login ke webinar ini
        $isRegistered = false;
        if (auth()->check()) {
            $isRegistered = Registration::where('user_id', auth()->id())
                ->where('webinar_id', $webinar->id)
                ->exists();
        }

        return view('webinars.show', compact('webinar', 'isRegistered'));
    }

    /**
     * Memproses pendaftaran user ke sebuah webinar.
     */
    public function register(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);
        $user = $request->user();

        // Cegah pendaftaran ganda oleh user yang sama
        $sudahDaftar = Registration::where('user_id', $user->id)
            ->where('webinar_id', $webinar->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah terdaftar di webinar ini.');
        }

        // Cegah pendaftaran kalau kuota sudah penuh
        if ($webinar->terisi >= $webinar->kuota) {
            return back()->with('error', 'Maaf, kuota webinar ini sudah penuh.');
        }

        // Simpan pendaftaran
        Registration::create([
            'user_id' => $user->id,
            'webinar_id' => $webinar->id,
            'registration_code' => 'REG-' . strtoupper(uniqid()),
            'status' => 'Terdaftar',
            'payment_proof' => null,
        ]);

        // Tambah jumlah pendaftar (terisi) di webinar
        $webinar->increment('terisi');

        return back()->with('success', 'Pendaftaran berhasil! Detail webinar akan dikirim ke email Anda.');
    }
}