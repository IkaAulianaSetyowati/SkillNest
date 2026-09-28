<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Transaksi, User, Webinar};

class DashboardController extends Controller
{
    public function __invoke()
    {
        $st = Webinar::selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');
        [$a, $d, $f] = [$st['Published'] ?? 0, $st['Draft'] ?? 0, $st['Selesai'] ?? 0];
        $total = $a + $d + $f;

        $ok = Transaksi::where('status', 'Berhasil')->get();
        $yr = $ok->max(fn ($t) => $t->tanggal->year) ?? now()->year;
        $bln = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $rev = collect($bln)->map(fn ($n, $i) => [$n, round($ok->filter(fn ($t) => $t->tanggal->year == $yr && $t->tanggal->month == $i + 1)->sum('jumlah') / 1e6, 2)])->values();

        // PERBAIKAN DI SINI: Ubah $k->nama menjadi $k->name (atau sesuai kolom di database kategori)
        $kat = Category::withSum('webinars', 'terisi')->get()
            ->map(fn ($k) => [$k->name ?? $k->nama, (int) $k->webinars_sum_terisi])->sortByDesc(1)->values();
            
        $tren = Webinar::orderByDesc('tanggal')->take(8)->get()->reverse()->values();
        $c = config('crud.webinar');

        return view('admin.dashboard', [
            'stats' => [
                ['Total Webinar', $total, 'cal', '#efeaff', '#6d3df2', "$a aktif · $d draft · $f selesai"],
                ['Total Pendaftar', number_format((int) Webinar::sum('terisi'), 0, ',', '.'), 'users', '#e0f0ff', '#2f7cf6', "dari $total webinar"],
                ['Total Pendapatan', 'Rp ' . number_format($ok->sum('jumlah'), 0, ',', '.'), 'dollar', '#dcf8e8', '#16a34a', $ok->count() . ' transaksi berhasil'],
                ['Total Pengguna', User::count(), 'target', '#ffeedd', '#f97316', User::where('status', 'Aktif')->count() . ' aktif'],
            ],
            'chart' => [
                'tren' => ['a' => $tren->pluck('terisi')->values(), 'b' => $tren->pluck('kuota')->values(), 'l' => $tren->map(fn ($w) => $w->tanggal->translatedFormat('d M'))->values()],
                'status' => [$a, $d, $f], 'kat' => $kat, 'rev' => $rev,
            ],
            'latest' => Webinar::with('kategori', 'organizer')->latest('id')->take(5)->get(),
            'kat' => $kat->take(5), 'yr' => $yr,
            'k' => 'webinar', 'c' => $c, 'refs' => CrudController::refs($c),
        ]);
    }
}