@extends('organizer.layouts.guest')
@section('title', 'Masuk')
@section('content')
<h3 style="margin-bottom:4px">Masuk sebagai Organizer</h3>
<p style="color:var(--m);font-size:13px;margin-bottom:14px">Dashboard hanya terbuka untuk organizer yang sudah diverifikasi admin.</p>
@foreach ($errors->all() as $e)<p class="err" style="margin-bottom:8px">{{ $e }}</p>@endforeach
<form method="POST" action="{{ route('organizer.login') }}" class="fm">@csrf
    <label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></label>
    <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
    <button class="btn" style="justify-content:center">Masuk</button>
</form>
<p style="margin-top:14px;font-size:13px">Belum punya akun? <a href="{{ route('organizer.register') }}" style="color:var(--p)">Daftar sebagai organizer</a></p>
@endsection