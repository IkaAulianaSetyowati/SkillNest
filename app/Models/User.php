<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'phone',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One-to-Many ke pendaftaran webinar (Registration).
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Relasi Has-Many-Through untuk mengambil semua Webinar yang diikuti User secara langsung.
     */
    public function webinars()
    {
        return $this->hasManyThrough(Webinar::class, Registration::class, 'user_id', 'id', 'id', 'webinar_id');
    }
}