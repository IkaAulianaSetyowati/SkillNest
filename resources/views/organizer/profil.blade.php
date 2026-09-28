@extends('organizer.layouts.app')
@section('title', 'Profil Organizer')
@section('content')
<div class="ph"><div class="ic"><x-icon name="users" :size="26" /></div><div><h1>Profil Organizer</h1><p>Data akun dan kontak organisasi Anda.</p></div></div>
<section class="card">
    @foreach ($errors->all() as $e)<p class="err" style="margin-bottom:6px">{{ $e }}</p>@endforeach
    <form method="POST" action="{{ route('organizer.profil.update') }}" class="fm" style="max-width:520px">@csrf @method('PUT')
        <label>Nama organisasi (hubungi admin untuk mengubah)<input value="{{ $o->nama }}" disabled></label>
        <label>Email<input value="{{ auth()->user()->email }}" disabled></label>
        <label>Nama pemilik akun<input name="name" value="{{ old('name', auth()->user()->name) }}" required></label>
        <label>Telepon / WhatsApp<input name="telepon" value="{{ old('telepon', $o->telepon) }}" required></label>
        <label>Password saat ini (isi hanya jika ingin ganti password)<input type="password" name="password_saat_ini" autocomplete="current-password"></label>
        <label>Password baru<input type="password" name="password" autocomplete="new-password"></label>
        <label>Ulangi password baru<input type="password" name="password_confirmation" autocomplete="new-password"></label>
        <div class="fa" style="justify-content:flex-start"><button class="btn">Simpan</button></div>
    </form>
    <p style="color:var(--m);font-size:12px;margin-top:12px">Terverifikasi sejak {{ $o->diverifikasi_at?->translatedFormat('d M Y') ?? '-' }}</p>
</section>
@endsection