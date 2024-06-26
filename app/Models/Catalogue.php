<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(CatalogueImage::class, 'catalogue_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }    

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_category_id')->where('parent_id', 0);
    }

    public function products()
    {
        return $this->hasMany(AuctionProduct::class, 'catalogue_id');
    }
}
