@extends('admin.layouts.app')
@section('title', 'Verifikasi Organizer')
@section('content')
<div class="ph"><div class="ic"><x-icon name="users" :size="26" /></div><div><h1>Verifikasi Organizer</h1><p>Tinjau dokumen, lalu setujui atau tolak pendaftar organizer.</p></div></div>
<section class="card">
<div class="tw"><table>
    <thead><tr><th>Organisasi</th><th>Pemilik</th><th>Email</th><th>Telepon</th><th>Daftar</th><th>Dokumen</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse ($rows as $o)
        <tr>
            <td>{{ $o->nama }}</td><td>{{ $o->user?->name }}</td><td>{{ $o->kontak }}</td><td>{{ $o->telepon }}</td>
            <td>{{ $o->created_at->translatedFormat('d M Y') }}</td>
            <td>@if ($o->dokumen_path)<a href="{{ route('admin.verifikasi.dokumen', $o) }}" target="_blank" rel="noopener" style="color:var(--p)">Buka dokumen</a>@else - @endif</td>
            <td><span class="bd {{ $o->verifikasi == 'Menunggu' ? 'wr' : 'rd' }}">{{ $o->verifikasi }}</span>@if ($o->alasan_penolakan)<br><small style="color:var(--m)">{{ $o->alasan_penolakan }}</small>@endif</td>
            <td><div class="ac">
                <form method="POST" action="{{ route('admin.verifikasi.setujui', $o) }}" onsubmit="return confirm('Setujui organizer ini? Mereka akan bisa mengakses dashboard organizer.')">@csrf<button class="btn">Setujui</button></form>
                <button type="button" class="btn gh" data-url="{{ route('admin.verifikasi.tolak', $o) }}" data-nama="{{ $o->nama }}" onclick="rej(this)">Tolak</button>
            </div></td>
        </tr>
    @empty
        <tr><td colspan="8" class="emp">Tidak ada organizer yang menunggu verifikasi.</td></tr>
    @endforelse
    </tbody>
</table></div>
@if ($rows->hasPages())
    <div class="pg">Halaman {{ $rows->currentPage() }} dari {{ $rows->lastPage() }}
        <span>@foreach ($rows->getUrlRange(1, $rows->lastPage()) as $n => $url)<a href="{{ $url }}" class="{{ $n == $rows->currentPage() ? 'on' : '' }}">{{ $n }}</a>@endforeach</span></div>
@endif
</section>

<dialog id="rejDlg" class="md">
    <form method="POST" id="rejForm">@csrf
        <h3>Tolak <span id="rejNama"></span></h3>
        <div class="fm">
            <label>Alasan penolakan (akan dilihat organizer)
                <textarea name="alasan" rows="4" required minlength="10" maxlength="500" style="border:1px solid var(--b);border-radius:10px;padding:9px 12px;font:inherit"></textarea>
            </label>
            <div class="fa"><button type="button" class="btn gh" onclick="document.getElementById('rejDlg').close()">Batal</button><button class="btn dn">Tolak</button></div>
        </div>
    </form>
</dialog>
@if ($errors->has('alasan'))<div class="toast bad">{{ $errors->first('alasan') }}</div>@endif
@endsection

@push('scripts')
<script>
function rej(b) {
    document.getElementById('rejForm').action = b.dataset.url;
    document.getElementById('rejNama').textContent = b.dataset.nama;
    document.getElementById('rejDlg').showModal();
}
</script>
@endpush