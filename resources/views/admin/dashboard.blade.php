@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="ph"><div class="ic"><x-icon name="home" :size="26" /></div><div><h1>Dashboard</h1><p>Ringkasan aktivitas dan statistik platform SkillNest.</p></div></div>

<div class="g g4">
@foreach ($stats as [$t,$v, $i,$bg, $col,$sub])
    <section class="card"><div class="st"><div class="ic" style="background:{{ $bg }};color:{{ $col }}"><x-icon :name="$i" :size="26" /></div><div><small>{{ $t }}</small><strong>{{$v }}</strong><span class="sub">{{ $sub }}</span></div></div></section>
@endforeach
</div>

<div class="g g3">
    <section class="card"><div class="ch"><h3>Tren Pendaftaran Webinar</h3></div><div id="cTren"></div></section>
    <section class="card"><div class="ch"><h3>Status Webinar</h3></div><div id="cStatus"></div></section>
    <section class="card"><div class="ch"><h3>Pendaftaran per Kategori</h3></div><div id="cKat"></div></section>
</div>

<section class="card">
    <div class="ch"><h3>Webinar Terbaru</h3>
        <div class="ac"><a class="btn gh" href="{{ route('admin.webinar.index') }}">Lihat Semua</a><button class="btn" onclick="crudOpen('new')"><x-icon name="plus" :size="15" /> Tambah Webinar</button></div>
    </div>
    @include('admin.crud._table', ['rows' => $latest])
</section>

<div class="g g6">
    <section class="card"><div class="ch"><h3>Kategori Populer</h3><a href="{{ route('admin.category.index') }}">Kelola Kategori</a></div>
        <div class="ls">@forelse ($kat as [$name,$n])<div class="li"><div class="ic" style="width:28px;height:28px"><x-icon name="folder" :size="13" /></div>{{ $name }}<em>{{$n }} pendaftar</em></div>@empty<p class="emp">Belum ada data.</p>@endforelse</div>
    </section>
    <section class="card"><div class="ch"><h3>Pendapatan per Bulan {{ $yr }}</h3></div><div id="cRev"></div></section>
</div>
@include('admin.crud._modals')
@endsection

@push('scripts')
<script>
const D = @json($chart),$ = id => document.getElementById(id), max = a => Math.max(1, ...a), none = t => `<p class="emp">${t}</p>`;
$('cTren').innerHTML = D.tren.a.length ? line(D.tren.a, D.tren.b, D.tren.l, 'Pendaftar', 'Kuota') : none('Belum ada webinar.');
$('cStatus').innerHTML = donut(...D.status);$('cKat').innerHTML = D.kat.length ? bars(D.kat, max(D.kat.map(k => k[1])), 130) : none('Belum ada kategori.');
$('cRev').innerHTML = bars(D.rev, max(D.rev.map(r => r[1])), 130, v => v ? v.toLocaleString('id-ID', {maximumFractionDigits: 1}) + 'jt' : '0');
</script>
@endpush