<?php

namespace Database\Seeders;

use App\Models\{Kategori, Organizer, Transaksi, User, Webinar};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SkillnestSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@skillnest.id'], [
            'name' => 'Admin SkillNest', 'password' => Hash::make('password'), 'peran' => 'Admin', 'status' => 'Aktif',
        ]);

        $k = collect(['Digital Marketing', 'Programming', 'Finance', 'Career', 'Health'])
            ->mapWithKeys(fn ($n) => [$n => Kategori::firstOrCreate(['nama' => $n])->id]);
        $o = collect([['Akademi Digital', 'halo@akademidigital.id', 'Terverifikasi'], ['Komunitas Karier', 'info@karier.id', 'Menunggu'], ['Studio Kode', 'tim@studiokode.id', 'Menunggu']])
            ->mapWithKeys(fn ($r) => [$r[0] => Organizer::firstOrCreate(['nama' => $r[0]], ['kontak' => $r[1], 'verifikasi' => $r[2]])->id]);

        foreach ([
            ['Digital Marketing untuk Pemula', 'Digital Marketing', 'Akademi Digital', 'Berbayar', 150000, '2026-09-12', '14:00', 150, 120, 'Published'],
            ['Web Development JavaScript', 'Programming', 'Studio Kode', 'Gratis', 0, '2026-09-15', '14:00', 200, 200, 'Selesai'],
            ['Manajemen Keuangan Pribadi', 'Finance', 'Akademi Digital', 'Berbayar', 100000, '2026-09-18', '10:00', 100, 60, 'Draft'],
            ['Career Preparation: CV & Interview', 'Career', 'Komunitas Karier', 'Gratis', 0, '2026-09-20', '15:00', 100, 80, 'Published'],
            ['Mental Health di Era Digital', 'Health', 'Akademi Digital', 'Berbayar', 75000, '2026-09-25', '19:00', 100, 75, 'Published'],
        ] as $r) {
            Webinar::firstOrCreate(['judul' => $r[0]], [
                'kategori_id' => $k[$r[1]], 'organizer_id' => $o[$r[2]], 'tipe' => $r[3], 'harga' => $r[4],
                'tanggal' => $r[5], 'waktu' => $r[6], 'kuota' => $r[7], 'terisi' => $r[8], 'status' => $r[9],
            ]);
        }

        foreach ([['Rina Marlina', 'Digital Marketing untuk Pemula', 150000, '2026-08-10'], ['Budi Santoso', 'Mental Health di Era Digital', 75000, '2026-09-16'], ['Andi Pratama', 'Manajemen Keuangan Pribadi', 100000, '2026-09-14']] as $t) {
            Transaksi::firstOrCreate(['peserta' => $t[0], 'webinar_id' => Webinar::where('judul', $t[1])->value('id')], ['jumlah' => $t[2], 'tanggal' => $t[3], 'status' => $t[0] == 'Andi Pratama' ? 'Menunggu' : 'Berhasil']);
        }
    }
}