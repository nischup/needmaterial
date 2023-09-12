<?php

namespace App\Services;

use App\Models\AuctionBidProduct;
use App\Models\AuctionBidProductImage;
use Illuminate\Support\Facades\DB;

class BidService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    public function store($auction_product_id, $request)
    {
        DB::beginTransaction();

        try {
            $bid = AuctionBidProduct::create([
                'user_id' => auth()->user()->id,
                'auction_product_id' => $auction_product_id,
                'title' => $request->title,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'price' => $request->price,
                'unit_id' => $request->unit,
                'made_in' => $request->made_in,
                'quantity' => $request->quantity,
                'delivery_charge' => $request->delivery_charge,
            ]);

         

            if ($request->images) {
                foreach ($request->images as $image) {
                    $list[] = [
                        'auction_bid_product_id' => $bid->id,
                        'src' => $this->imageService->saveImage($image),
                    ];
                }

                AuctionBidProductImage::insert($list);
            }

            DB::commit();

            return $bid;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
