<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'tagline',
        'about_text',
        'phone',
        'email',
        'service_area',
        'hours',
        'facebook_url',
        'instagram_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}