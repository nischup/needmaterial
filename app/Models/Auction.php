<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const BUYING_SERVICE = 1;
    const SELLING_SERVICE = 2;
    const QUOTATION_SERVICE = 3;

    public function getServiceAttribute()
    {
        return match ($this->attributes['service_type']) {
            self::BUYING_SERVICE => __('Reverse'),
            self::SELLING_SERVICE => __('Selling'),
            self::QUOTATION_SERVICE => __('Quotation'),
            default => null,
        };
    }

    public function getThumbnailAttribute()
    {
        return $this->attributes['thumbnail'] ? url('storage/' . $this->attributes['thumbnail']) : asset('frontend/images/auction/jewelry/auction-1.jpg');
    }

    public function products()
    {
        return $this->hasMany(AuctionProduct::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
