@extends('organizer.layouts.app')
@section('title', 'Peserta & Transaksi')
@section('content')
<div class="ph"><div class="ic"><x-icon name="card" :size="26" /></div><div><h1>Peserta & Transaksi</h1><p>Pembayaran peserta untuk webinar Anda (hanya lihat).</p></div></div>
<section class="card">
    <form class="tb" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama peserta..." aria-label="Cari">
        <select class="fl" name="filter" onchange="this.form.submit()" aria-label="Filter status">
            <option value="">Semua Status</option>
            @foreach (['Berhasil', 'Menunggu', 'Gagal'] as $v)<option @selected(request('filter') == $v)>{{ $v }}</option>@endforeach
        </select>
    </form>
    <div class="tw"><table>
        <thead><tr><th>No</th><th>Peserta</th><th>Webinar</th><th>Jumlah</th><th>Tanggal</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($rows as $t)
            <tr>
                <td>{{ $rows->firstItem() + $loop->index }}</td><td>{{ $t->peserta }}</td><td>{{ $t->webinar->judul }}</td>
                <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td><td>{{ $t->tanggal->translatedFormat('d M Y') }}</td>
                <td><span class="bd {{ ['Berhasil' => 'ok', 'Menunggu' => 'wr', 'Gagal' => 'rd'][$t->status] ?? 'gy' }}">{{ $t->status }}</span></td>
            </tr>
        @empty
            <tr><td colspan="6" class="emp">Belum ada transaksi.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if ($rows->total())
        <div class="pg">Menampilkan {{ $rows->firstItem() }}–{{ $rows->lastItem() }} dari {{ $rows->total() }} data
            <span>@foreach ($rows->getUrlRange(1, $rows->lastPage()) as $n => $url)<a href="{{ $url }}" class="{{ $n == $rows->currentPage() ? 'on' : '' }}">{{ $n }}</a>@endforeach</span></div>
    @endif
</section>
@endsection