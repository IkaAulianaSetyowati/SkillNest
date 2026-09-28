<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title') · SkillNest Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body>
@php
    $nav = [
        'MAIN' => [
            ['dashboard', 'Dashboard', 'home'], 
            ['webinar.index', 'Kelola Webinar', 'cal'], 
            ['category.index', 'Kelola Kategori', 'folder'], 
            ['pengguna.index', 'Kelola Pengguna', 'users'], 
            ['organizer.index', 'Kelola Organizer', 'cal'], 
            ['transaksi.index', 'Kelola Transaksi', 'card']
        ],
    ];
    $menunggu = \App\Models\Organizer::where('verifikasi', 'Menunggu')->count();
    $user = auth()->user();
@endphp

<aside id="side">

    {{-- LOGO SKILLNEST --}}
    <div class="logo">
        <img src="{{ asset('images/LOGO SKILLNEST.png') }}" alt="SkillNest">
        <span>
            SkillNest
            <small>Learn • Connect • Grow</small>
        </span>
    </div>

    <nav class="nav">
        @foreach ($nav as $g => $items)
            <div class="grp">{{ $g }}</div>

            @foreach ($items as [$r, $t, $i])
                <a href="{{ route('admin.'.$r) }}" class="{{ request()->routeIs('admin.'.explode('.', $r)[0].'*') ? 'on' : '' }}">
                    <x-icon :name="$i" />
                    <span class="lbl">{{ $t }}</span>
                </a>
            @endforeach
        @endforeach
    </nav>

    <div class="me">
        <div class="av">{{ strtoupper(substr($user->name, 0, 2)) }}</div>

        <div>
            <b>{{ $user->name }}</b>
            <br>
            <small style="color:var(--m)">
                {{ $user->peran ?? 'Administrator' }}
            </small>
        </div>
    </div>

    @if (Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}" style="padding:8px">
            @csrf

            <button style="all:unset;cursor:pointer;display:flex;gap:10px;padding:10px;align-items:center;font-weight:500">
                <x-icon name="out" />
                <span class="lbl">Keluar</span>
            </button>
        </form>
    @endif

</aside>

<div class="main">

    <header>

        <form class="srch" action="{{ route('admin.webinar.index') }}">
            <x-icon name="search" />

            <input
                name="q"
                aria-label="Cari webinar"
                placeholder="Cari webinar..."
                value="{{ request()->routeIs('admin.webinar.*') ? request('q') : '' }}"
            >
        </form>

        @if ($menunggu)
            <a class="chip" href="{{ route('admin.organizer.index', ['filter' => 'Menunggu']) }}">
                {{ $menunggu }} organizer menunggu verifikasi
            </a>
        @endif

        <span class="bell" @if(!$menunggu) style="margin-left:auto" @endif>
            <x-icon name="bell" />

            @if ($menunggu)
                <b>{{ $menunggu }}</b>
            @endif
        </span>

        <div class="av">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>

    </header>

    <main id="view">
        @yield('content')
    </main>

</div>

@if (session('ok'))
    <div class="toast" role="status">
        {{ session('ok') }}
    </div>
@endif

@if (session('err'))
    <div class="toast bad" role="alert">
        {{ session('err') }}
    </div>
@endif

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')

</body>
</html>