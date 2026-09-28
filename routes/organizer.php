<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/** Semua query dibatasi ke webinar milik organizer yang login (mencegah akses data organizer lain). */
class WebinarController extends Controller
{
    private function org(Request $r) { return $r->attributes->get('organizer'); }

    public function index(Request $r)
    {
        $c = config('crud_organizer.webinar');
        $q = $this->org($r)->webinars()->with('kategori');
        if ($s = $r->q) $q->where('judul', 'like', "%$s%");
        if ($f = $r->filter) $q->where('status', $f);

        return view('organizer.webinar.index', [
            'k' => 'webinar', 'c' => $c, 'rp' => 'organizer', 'refs' => CrudController::refs($c),
            'rows' => $q->latest('id')->paginate(8)->withQueryString(),
        ]);
    }

    public function store(Request $r)
    {
        $this->org($r)->webinars()->create($this->data($r));   // organizer_id diisi otomatis oleh relasi
        return back()->with('ok', 'Webinar berhasil ditambahkan.');
    }

    public function update(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);
        $d = $this->data($r);

        if ($d['kuota'] < $w->terisi) {
            throw ValidationException::withMessages(['kuota' => "Kuota tidak boleh kurang dari jumlah pendaftar saat ini ({$w->terisi})."]);
        }
        $w->update($d);

        return back()->with('ok', 'Perubahan webinar disimpan.');
    }

    public function destroy(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);

        if ($w->terisi > 0 || $w->transaksis()->exists()) {
            return back()->with('err', 'Webinar yang sudah punya pendaftar atau transaksi tidak bisa dihapus. Ubah statusnya menjadi Selesai.');
        }
        if ($w->video_path) Storage::disk('public')->delete($w->video_path);
        if ($w->sertifikat_path) Storage::disk('public')->delete($w->sertifikat_path);
        $w->delete();

        return back()->with('ok', 'Webinar dihapus.');
    }

    /** Unggah / ganti video rekaman webinar. */
    public function uploadVideo(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);
        $r->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-matroska|max:102400', // 100MB
        ]);

        if ($w->video_path) Storage::disk('public')->delete($w->video_path);
        $w->update(['video_path' => $r->file('video')->store('webinar-video', 'public')]);

        return back()->with('ok', 'Video webinar berhasil diunggah.');
    }

    public function deleteVideo(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);
        if ($w->video_path) {
            Storage::disk('public')->delete($w->video_path);
            $w->update(['video_path' => null]);
        }
        return back()->with('ok', 'Video webinar dihapus.');
    }

    /** Unggah / ganti template sertifikat webinar. */
    public function uploadSertifikat(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);
        $r->validate([
            'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ]);

        if ($w->sertifikat_path) Storage::disk('public')->delete($w->sertifikat_path);
        $w->update(['sertifikat_path' => $r->file('sertifikat')->store('webinar-sertifikat', 'public')]);

        return back()->with('ok', 'Sertifikat webinar berhasil diunggah.');
    }

    public function deleteSertifikat(Request $r, $id)
    {
        $w = $this->org($r)->webinars()->findOrFail($id);
        if ($w->sertifikat_path) {
            Storage::disk('public')->delete($w->sertifikat_path);
            $w->update(['sertifikat_path' => null]);
        }
        return back()->with('ok', 'Sertifikat webinar dihapus.');
    }

    private function data(Request $r): array
    {
        $rules = [];
        foreach (config('crud_organizer.webinar.fields') as $f) $rules[$f[0]] = $f[3];
        $d = $r->validate($rules);
        $d['harga'] = $d['tipe'] == 'Gratis' ? 0 : (int) ($d['harga'] ?? 0);

        return $d;
    }
}