<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBidProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_diff'];

    public function bidder()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(AuctionProduct::class,'auction_product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function madein()
    {
        return $this->belongsTo(MadeIn::class, 'made_in');
    }

    public function images()
    {
        return $this->hasMany(AuctionBidProductImage::class, 'auction_bid_product_id');
    }

    public function getCreatedAtDiffAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
