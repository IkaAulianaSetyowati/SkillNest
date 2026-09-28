<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/** Satu controller untuk semua CRUD; entitas dibaca dari nama route (admin.{entitas}.aksi). */
class CrudController extends Controller
{
    private function cfg(Request $r): array
    {
        $k = explode('.', $r->route()->getName())[1];
        abort_unless(config("crud.$k"), 404);
        return [$k, config("crud.$k")];
    }

    /** Opsi dropdown untuk field bertipe "ref" => [field => [id => label]] */
    public static function refs(array $c)
    {
        return collect($c['fields'])->filter(fn ($f) => $f[2] == 'ref')
            ->mapWithKeys(fn ($f) => [$f[0] => $f[4]::orderBy($f[5])->pluck($f[5], 'id')]);
    }

    public function index(Request $r)
    {
        [$k, $c] = $this->cfg($r);
        $q = $c['model']::query()->with($c['with'] ?? [])->withCount($c['count'] ?? []);

        if ($s = $r->q) {
            $q->where(function ($w) use ($c, $s) {
                foreach ($c['search'] as $col) $w->orWhere($col, 'like', "%$s%");
            });
        }
        if (($f = $r->filter) && isset($c['filter'])) $q->where($c['filter'], $f);

        return view('admin.crud.index', [
            'k' => $k, 'c' => $c, 'refs' => self::refs($c),
            'rows' => $q->latest('id')->paginate(8)->withQueryString(),
        ]);
    }

    public function store(Request $r)
    {
        [$k, $c] = $this->cfg($r);
        $c['model']::forceCreate($this->data($r, $c));
        return back()->with('ok', $c['label'] . ' berhasil ditambahkan.');
    }

    public function update(Request $r, $id)
    {
        [$k, $c] = $this->cfg($r);
        $c['model']::findOrFail($id)->forceFill($this->data($r, $c, $id))->save();
        return back()->with('ok', 'Perubahan ' . strtolower($c['label']) . ' disimpan.');
    }

    public function destroy(Request $r, $id)
    {
        [$k, $c] = $this->cfg($r);
        $row = $c['model']::findOrFail($id);

        if (($c['guard'] ?? null) && $row->{$c['guard']}()->exists()) {
            return back()->with('err', 'Data ini masih dipakai data lain, jadi belum bisa dihapus.');
        }
        if ($row instanceof User && $row->is($r->user())) {
            return back()->with('err', 'Anda tidak bisa menghapus akun yang sedang dipakai.');
        }
        $row->delete();
        return back()->with('ok', $c['label'] . ' dihapus.');
    }

    private function data(Request $r, array $c, $id = null): array
    {
        $rules = [];
        foreach ($c['fields'] as $f) {
            $rules[$f[0]] = $f[2] == 'password'
                ? ($id ? 'nullable' : 'required') . '|min:8'
                : str_replace('{id}', $id ?? 'NULL', $f[3]);
        }
        $d = $r->validate($rules);

        if (array_key_exists('harga', $d)) {
            $d['harga'] = ($d['tipe'] ?? '') == 'Gratis' ? 0 : (int) ($d['harga'] ?? 0);
        }
        if (! empty($d['password'])) $d['password'] = Hash::make($d['password']);
        else unset($d['password']);

        return $d;
    }
}