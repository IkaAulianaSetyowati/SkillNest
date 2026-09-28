{{-- Satu dialog untuk tambah / lihat / ubah. Variabel: $k, $c, $refs --}}
<dialog id="crudDlg" class="md">
<form method="POST" id="crudForm" data-store="{{ route("admin.$k.store") }}" data-update="{{ route("admin.$k.update", '__ID__') }}" data-label="{{ $c['label'] }}">
    @csrf
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_id" value="{{ old('_id') }}">
    <h3 id="crudTitle"></h3>
    <div class="fm">
    @foreach ($c['fields'] as $f)
        @php [$n, $l, $t] = $f; @endphp
        <label>{{ $l }}
            @if ($t == 'select')
                <select name="{{ $n }}">@foreach ($f[4] as $v)<option @selected(old($n) == $v)>{{ $v }}</option>@endforeach</select>
            @elseif ($t == 'ref')
                <select name="{{ $n }}">@foreach ($refs[$n] as $id => $nm)<option value="{{ $id }}" @selected(old($n) == $id)>{{ $nm }}</option>@endforeach</select>
            @else
                <input name="{{ $n }}" type="{{ $t }}" value="{{ $t == 'password' ? '' : old($n) }}" @if ($t == 'number') min="0" @endif @if ($t == 'password') placeholder="Kosongkan jika tidak diubah (min. 8 karakter)" autocomplete="new-password" @endif>
            @endif
            @error($n)<small class="err">{{ $message }}</small>@enderror
        </label>
    @endforeach
    <div class="fa">
        <button type="button" class="btn gh" onclick="document.getElementById('crudDlg').close()">Batal</button>
        <button class="btn" id="crudSave">Simpan</button>
    </div>
    </div>
</form>
</dialog>
@if ($errors->any())
    @php $eid = old('_id'); @endphp
    <script>window.addEventListener('DOMContentLoaded', () => crudOpen(@json($eid ? 'edit' : 'new'), @json($eid ? ['id' => (int) $eid] : null), true));</script>
@endif