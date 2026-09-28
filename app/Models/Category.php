<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function webinars()
    {
        return $this->hasMany(Webinar::class, 'kategori_id');
    }

    public function getTranslatedNameAttribute()
    {
        return app()->getLocale() === 'en' && $this->name_en
            ? $this->name_en
            : $this->name;
    }

    public function getTranslatedDescriptionAttribute()
    {
        return app()->getLocale() === 'en' && $this->description_en
            ? $this->description_en
            : $this->description;
    }
}