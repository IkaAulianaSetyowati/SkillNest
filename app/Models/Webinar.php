<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Webinar extends Model
{
    protected $guarded = [];
    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi Eloquent
    public function kategori() 
    { 
        return $this->belongsTo(Category::class, 'kategori_id'); 
    }
    
    public function organizer() 
    { 
        return $this->belongsTo(Organizer::class); 
    }
    
    public function transaksis() 
    { 
        return $this->hasMany(Transaksi::class); 
    }

    // --- ACCESSOR TAMBAHAN ---
    public function getCategoryAttribute()
    {
        if ($this->relationLoaded('kategori') && $this->kategori) {
            return $this->kategori->nama ?? $this->kategori->name ?? 'Umum';
        }
        
        if (isset($this->attributes['category'])) return $this->attributes['category'];
        if (isset($this->attributes['kategori'])) return $this->attributes['kategori'];

        try {
            if ($this->kategori) {
                return $this->kategori->nama ?? $this->kategori->name ?? 'Umum';
            }
        } catch (\Exception $e) {
            // Abaikan jika tabel kategori belum ada
        }

        return 'Umum';
    }

    public function getSpeakerAttribute()
    {
        if (!empty($this->attributes['speaker'])) {
            return $this->attributes['speaker'];
        }

        if ($this->relationLoaded('organizer') && $this->organizer) {
            return $this->organizer->nama ?? $this->organizer->name ?? 'Penyelenggara';
        }

        try {
            if ($this->organizer) {
                return $this->organizer->nama ?? $this->organizer->name ?? 'Penyelenggara';
            }
        } catch (\Exception $e) {}

        return 'Penyelenggara';
    }

    public function getDateAttribute()
    {
        $tanggal = $this->attributes['tanggal'] ?? null;

        if (!$tanggal) {
            return $this->attributes['date'] ?? null;
        }

        $tanggalOnly = Carbon::parse($tanggal)->format('Y-m-d');
        $waktu = $this->attributes['waktu'] ?? '00:00:00';

        return Carbon::parse($tanggalOnly . ' ' . $waktu);
    }
}