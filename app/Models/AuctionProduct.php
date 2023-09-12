<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function made_by()
    {
        return $this->belongsTo(MadeIn::class, 'made_in');
    }

    public function ownBids()
    {
        return $this->hasMany(AuctionBidProduct::class)
            ->where('user_id', auth()->user()->id);
    }

    public function bids()
    {
        return $this->hasMany(AuctionBidProduct::class)->orderBy('id', 'desc');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function images()
    {
        return $this->hasMany(AuctionProductImage::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(AuctionProductImage::class);
    }
}
