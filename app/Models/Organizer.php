<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $guarded = [];
    protected $casts = ['diverifikasi_at' => 'datetime'];

    public function webinars() { return $this->hasMany(Webinar::class); }
    public function user() { return $this->belongsTo(User::class); }
}