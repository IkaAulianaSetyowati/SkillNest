<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = [];
    protected $casts = ['tanggal' => 'date'];

    public function webinar() { return $this->belongsTo(Webinar::class); }
}