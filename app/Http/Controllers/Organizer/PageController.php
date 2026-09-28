<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PageController extends Controller
{
    /**
     * Halaman Utama / Dashboard Organizer.
     */
    public function index(Request $r)
    {
        $organizer = $r->attributes->get('organizer');
        
        // Kamu bisa mengirim data statistik atau ringkasan ke view di sini jika diperlukan
        return view('organizer.index', compact('organizer'));
    }

    /** Peserta & transaksi: hanya baca. Organizer tidak boleh mengubah data pembayaran. */
    public function transaksi(Request $r)
    {
        $o = $r->attributes->get('organizer');
        $q = Transaksi::with('webinar')->whereHas('webinar', fn ($w) => $w->where('organizer_id', $o->id));
        if ($s = $r->q) $q->where('peserta', 'like', "%$s%");
        if ($f = $r->filter) $q->where('status', $f);

        return view('organizer.transaksi', ['rows' => $q->latest('id')->paginate(10)->withQueryString()]);
    }

    public function profil(Request $r)
    {
        return view('organizer.profil', ['o' => $r->attributes->get('organizer')]);
    }

    public function profilUpdate(Request $r)
    {
        $d = $r->validate([
            'name' => 'required|string|max:100',
            'telepon' => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'password_saat_ini' => ['required_with:password', 'nullable', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $u = ['name' => $d['name']];
        if (! empty($d['password'])) $u['password'] = Hash::make($d['password']);
        $r->user()->forceFill($u)->save();
        $r->attributes->get('organizer')->update(['telepon' => $d['telepon']]);

        return back()->with('ok', 'Profil diperbarui.');
    }
}