<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Cachable;

    protected $guarded = [];

    public $timestamps = false;

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getIconAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/' . $this->attributes['icon']) : asset('frontend\images\auction\06.png');
    }

    public function getIconOriginalAttribute()
    {
        return $this->attributes['icon'];
    }

    public function catalogues()
    {
        return $this->hasMany(Catalogue::class, 'category_id');
    }

    public function products()
    {
        return $this->hasManyThrough(AuctionProduct::class, Catalogue::class);
    }
}
