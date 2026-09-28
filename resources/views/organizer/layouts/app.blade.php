<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title') · SkillNest Organizer</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@php
    $o = request()->attributes->get('organizer');
    $user = auth()->user();
    $nav = [['dashboard', 'Dashboard', 'home'], ['webinar.index', 'Kelola Webinar', 'cal'], ['transaksi', 'Peserta & Transaksi', 'card'], ['profil', 'Profil Organizer', 'users']];
@endphp
<aside id="side">
    <div class="logo"><img src="{{ asset('images/logo.png') }}" alt="SkillNest"><span>SkillNest<small>Portal Organizer</small></span></div>
    <nav class="nav">
        <div class="grp">ORGANIZER</div>
        @foreach ($nav as [$r, $t, $i])
            <a href="{{ route('organizer.'.$r) }}" class="{{ request()->routeIs('organizer.'.explode('.', $r)[0].'*') ? 'on' : '' }}"><x-icon :name="$i" /><span class="lbl">{{ $t }}</span></a>
        @endforeach
    </nav>
    <div class="me"><div class="av">{{ strtoupper(substr($user->name, 0, 2)) }}</div><div><b>{{ $user->name }}</b><br><small style="color:var(--m)">{{ $o->nama }}</small></div></div>
    <form method="POST" action="{{ route('organizer.logout') }}" style="padding:8px">@csrf
        <button style="all:unset;cursor:pointer;display:flex;gap:10px;padding:10px;align-items:center;font-weight:500"><x-icon name="out" /><span class="lbl">Keluar</span></button>
    </form>
</aside>
<div class="main">
    <header>
        <span class="chip" style="margin-left:0">{{ $o->nama }}</span>
        <span class="bd ok" style="margin-left:auto">Terverifikasi</span>
        <div class="av">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
    </header>
    <main id="view">@yield('content')</main>
</div>
@if (session('ok'))<div class="toast" role="status">{{ session('ok') }}</div>@endif
@if (session('err'))<div class="toast bad" role="alert">{{ session('err') }}</div>@endif
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>