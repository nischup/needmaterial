<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerAd extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(BannerAdImage::class, 'banner_ad_id', 'id');
    }

}
