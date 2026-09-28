<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard Organizer · SkillNest</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>

<aside id="side">
    {{-- LOGO SKILLNEST --}}
    <div class="logo">
        <img src="{{ asset('images/LOGO SKILLNEST.png') }}" alt="SkillNest" onerror="this.style.display='none'">
        <span>
            SkillNest
            <small>Organizer Panel</small>
        </span>
    </div>

    <nav class="nav">
        <div class="grp">MENU UTAMA</div>
        <a href="{{ url('/organizer/dashboard') }}" class="on">
            <span class="lbl">Dashboard</span>
        </a>
        <a href="#">
            <span class="lbl">Kelola Webinar Saya</span>
        </a>
        <a href="#">
            <span class="lbl">Peserta & Tiket</span>
        </a>
    </nav>

    <div class="me">
        <div class="av">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div>
            <b>{{ $user->name }}</b>
            <br>
            <small style="color:var(--m)">Organizer</small>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" style="padding:8px">
        @csrf
        <button style="all:unset;cursor:pointer;display:flex;gap:10px;padding:10px;align-items:center;font-weight:500;color:#ef4444;">
            <span class="lbl">Keluar</span>
        </button>
    </form>
</aside>

<div class="main">
    <header>
        <div style="font-weight: 600; font-size: 16px;">Dashboard Penyelenggara Webinar</div>
        <div class="av">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
    </header>

    <main id="view" style="padding: 24px;">
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 8px;">Selamat Datang, {{ $user->name }}! 👋</h2>
            <p style="color: #6b7280; font-size: 14px;">Ini adalah pusat kendali organizer Anda. Dari sini Anda dapat membuat dan mengelola berbagai acara webinar dengan mudah.</p>
        </div>
    </main>
</div>

</body>
</html>