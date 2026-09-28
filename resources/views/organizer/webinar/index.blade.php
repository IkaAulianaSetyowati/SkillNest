@extends('organizer.layouts.app')
@section('title', 'Kelola Webinar')
@section('content')
@php 
    $flt = isset($c['fields']) ? collect($c['fields'])->first(fn ($f) => $f[0] == ($c['filter'] ?? '')) : null; 
@endphp

<div class="ph">
    <div class="ic">
        <x-icon :name="$c['icon'] ?? 'folder'" :size="26" />
    </div>
    <div>
        <h1>Kelola Webinar</h1>
        <p>{{ $c['sub'] ?? '' }}</p>
    </div>
</div>

<section class="card">
    <form class="tb" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Cari webinar..." aria-label="Cari">
        
        @if($flt)
            <select class="fl" name="filter" onchange="this.form.submit()" aria-label="Filter {{ $flt[1] ?? 'Data' }}">
                <option value="">Semua {{ $flt[1] ?? 'Data' }}</option>
                @if(isset($flt[4]) && is_array($flt[4]))
                    @foreach ($flt[4] as $v)
                        <option value="{{ $v }}" @selected(request('filter') == $v)>{{ $v }}</option>
                    @endforeach
                @endif
            </select>
        @endif

        <button type="button" class="btn" onclick="crudOpen('new')">
            <x-icon name="plus" :size="15" /> Tambah Webinar
        </button>
    </form>
    
    @include('admin.crud._table')
</section>

@include('admin.crud._modals')
@endsection