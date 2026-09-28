<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('admin.verifikasi', [
            'rows' => Organizer::with('user')->whereIn('verifikasi', ['Menunggu', 'Ditolak'])
                ->orderByRaw("verifikasi = 'Menunggu' desc")->latest()->paginate(10),
        ]);
    }

    /** Dokumen ada di storage privat; hanya admin yang bisa membukanya lewat rute ini. */
    public function dokumen(Organizer $organizer)
    {
        abort_unless($organizer->dokumen_path && Storage::exists($organizer->dokumen_path), 404);
        return Storage::response($organizer->dokumen_path);
    }

    public function setujui(Request $r, Organizer $organizer)
    {
        $this->set($r, $organizer, 'Terverifikasi', null);
        return back()->with('ok', "{$organizer->nama} disetujui. Mereka kini bisa mengakses dashboard organizer.");
    }

    public function tolak(Request $r, Organizer $organizer)
    {
        $d = $r->validate(['alasan' => 'required|string|min:10|max:500']);
        $this->set($r, $organizer, 'Ditolak', $d['alasan']);
        return back()->with('ok', "{$organizer->nama} ditolak.");
    }

    private function set(Request $r, Organizer $o, string $status, ?string $alasan): void
    {
        $o->forceFill([
            'verifikasi' => $status, 'alasan_penolakan' => $alasan,
            'diverifikasi_at' => now(), 'diverifikasi_oleh' => $r->user()->id,
        ])->save();
    }
}