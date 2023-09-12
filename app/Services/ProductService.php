<?php

namespace App\Services;

use App\Models\AuctionProduct;
use App\Models\Product;

class ProductService
{
    public function storeProduct($auctionId, $data)
    {
        $product = AuctionProduct::create([
            'user_id' => auth()->user()->id,
            'auction_id' => $auctionId,
            'catalogue_id' => $data['catalogue'],
            'brand_id' => $data['brand'],
            'unit_id' => $data['unit'],
            'price' => $data['price'],
            'made_in' => $data['made_in'],
            'quantity' => $data['quantity'],
        ]);

        return $product->id;
    }
}
