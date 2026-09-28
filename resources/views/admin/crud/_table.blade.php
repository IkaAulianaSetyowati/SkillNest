{{-- Variabel: $k (kunci entitas), $c (config), $rows (Collection atau Paginator) --}}
@php
    $badge = ['Published' => 'ok', 'Draft' => 'wr', 'Selesai' => 'pr', 'Berhasil' => 'ok', 'Menunggu' => 'wr', 'Gagal' => 'rd', 'Aktif' => 'ok', 'Nonaktif' => 'gy', 'Terverifikasi' => 'ok', 'Ditolak' => 'rd', 'Gratis' => 'ok', 'Berbayar' => 'rd'];
    $paged = $rows instanceof \Illuminate\Pagination\AbstractPaginator;
@endphp
<div class="tw">
<table>
    <thead><tr><th>No</th>@foreach ($c['columns'] as $col)<th>{{ $col[1] }}</th>@endforeach<th>Aksi</th></tr></thead>
    <tbody>
    @forelse ($rows as $row)
        @php
            $p = ['id' => $row->id];
            foreach ($c['fields'] as $f) $p[$f[0]] = $f[2] == 'password' ? '' : $row->getRawOriginal($f[0]);
        @endphp
        <tr>
            <td>{{ ($paged ? $rows->firstItem() : 1) + $loop->index }}</td>
            @foreach ($c['columns'] as $col)
                @php $v = data_get($row, $col[0]); @endphp
                <td>
                @switch($col[2] ?? null)
                    @case('badge')<span class="bd {{ $badge[$v] ?? 'bl' }}">{{ $v }}</span>@break
                    @case('rp'){{ $v ? 'Rp '.number_format($v, 0, ',', '.') : '-' }}@break
                    @case('date'){{ \Carbon\Carbon::parse($v)->translatedFormat('d M Y') }}@break
                    @case('fill'){{ $row->terisi }}/{{ $row->kuota }}@break
                    @default{{ $v }}
                @endswitch
                </td>
            @endforeach
            <td>
                <div class="ac">
                    <button type="button" class="ib" aria-label="Lihat" title="Lihat" data-row="{{ json_encode($p) }}" onclick="crudOpen('view',JSON.parse(this.dataset.row))"><x-icon name="eye" :size="15" /></button>
                    <button type="button" class="ib" aria-label="Ubah" title="Ubah" data-row="{{ json_encode($p) }}" onclick="crudOpen('edit',JSON.parse(this.dataset.row))"><x-icon name="edit" :size="15" /></button>
                    <form method="POST" action="{{ route("admin.$k.destroy", $row->id) }}" class="inl" onsubmit="return confirm('Hapus data ini? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button class="ib d" aria-label="Hapus" title="Hapus"><x-icon name="trash" :size="15" /></button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="{{ count($c['columns']) + 2 }}" class="emp">Belum ada data {{ strtolower($c['label']) }}.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@if ($paged && $rows->total())
    <div class="pg">Menampilkan {{ $rows->firstItem() }}–{{ $rows->lastItem() }} dari {{ $rows->total() }} data
        <span>@foreach ($rows->getUrlRange(1, $rows->lastPage()) as $n => $url)<a href="{{ $url }}" class="{{ $n == $rows->currentPage() ? 'on' : '' }}">{{ $n }}</a>@endforeach</span>
    </div>
@endif