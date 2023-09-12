<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBidProductImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function getSrcAttribute()
    {
        return $this->attributes['src'] ? asset('storage/' . $this->attributes['src']) : asset('frontend\images\product-placeholder.webp');
    }

    public function getSrcOriginalAttribute()
    {
        return $this->attributes['src'];
    }
}
