@extends('admin.layouts.app')
@section('title', 'Kelola '.$c['label'])
@section('content')
@php $flt = isset($c['filter']) ? collect($c['fields'])->first(fn ($f) => $f[0] == $c['filter']) : null; @endphp
<div class="ph">
    <div class="ph-l">
        <div class="ic"><x-icon :name="$c['icon']" :size="26" /></div>
        <div><h1>Kelola {{ $c['label'] }}</h1><p>{{ $c['sub'] }}</p></div>
    </div>
    <div class="ph-r">
        <form class="tb" method="GET">
            <div class="tb-s">
                <x-icon name="search" :size="16" />
                <input name="q" value="{{ request('q') }}" placeholder="Cari {{ strtolower($c['label']) }}..." aria-label="Cari">
            </div>
            @if ($flt)
                <select class="fl" name="filter" onchange="this.form.submit()" aria-label="Filter {{ $flt[1] }}">
                    <option value="">Semua {{ $flt[1] }}</option>
                    @foreach ($flt[4] as $v)<option @selected(request('filter') == $v)>{{ $v }}</option>@endforeach
                </select>
            @endif
        </form>
        <button type="button" class="btn" onclick="crudOpen('new')"><x-icon name="plus" :size="15" /> Tambah {{ $c['label'] }}</button>
    </div>
</div>
<section class="card">
    @include('admin.crud._table')
</section>
@include('admin.crud._modals')
@endsection