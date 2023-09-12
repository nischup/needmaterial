<?php

namespace App\Services;

use App\Models\AuctionProduct;
use App\Models\AuctionProductImage;
use App\Models\AuctionTargetSupplier;

class AuctionService
{
    public function storeAuctionProducts($auctionId, $selectedProducts)
    {
        if ($selectedProducts && count($selectedProducts)) {
            $list = [];
            foreach ($selectedProducts as $selectedProduct) {
                $auctionProduct = AuctionProduct::create([
                    'auction_id' => $auctionId,
                    'catalogue_id' => $selectedProduct['catalogue'],
                    'product_title' => $selectedProduct['product_title'] ? $selectedProduct['product_title'] : null,
                    'brand_id' => $selectedProduct['brand'] ? $selectedProduct['brand'] : null,
                    'unit_id' => $selectedProduct['unit'] ? $selectedProduct['unit'] : null,
                    'exact_item_require' => $selectedProduct['is_exact_item'],
                    'made_in' => $selectedProduct['made_in'] ? $selectedProduct['made_in'] : null,
                    'quantity' => $selectedProduct['quantity'],
                    'description' => $selectedProduct['description'],
                ]);

                foreach ($selectedProduct['images'] as $image) {
                    // will ignore images which are not exists
                    if (isset($image['src_original']) && $image['src_original']) {
                        $list[] = [
                            'auction_product_id' => $auctionProduct->id,
                            'src' => $image['src_original'],
                        ];
                    }
                }

                AuctionProductImage::insert($list);
            }
        }
    }

    public function storeSelectedSuppliers($auctionId, $selectedSuppliers)
    {
        if ($selectedSuppliers && count($selectedSuppliers)) {
            $list = [];
            foreach ($selectedSuppliers as $selectedSupplier) {
                $list[] = [
                    'auction_id' => $auctionId,
                    'supplier_id' => $selectedSupplier,
                ];
            }

            AuctionTargetSupplier::insert($list);
        }
    }
}
