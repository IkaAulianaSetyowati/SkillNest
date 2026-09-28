<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'webinar_id',
        'payment_method',
        'payment_proof',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Webinar
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }
}