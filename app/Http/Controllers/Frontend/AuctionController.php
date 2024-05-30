<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\BidSubmissionSuccessful;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\MadeIn;
use App\Models\Unit;
use App\Models\User;
use App\Models\AuctionBidProduct;
use App\Models\AuctionProduct;
use App\Models\CatalogueImage;
use App\Services\BidService;
use App\Services\ImageService;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuctionController extends Controller
{

    private $bidService;
    private $smsService;

    public function __construct(BidService $bidService, SMSService $smsService)
    {
        $this->bidService = $bidService;
        $this->smsService = $smsService;
    }

    /**
     * @throws \Throwable
     */
    public function submit($id, Request $request)
    {
        $auctionProduct = AuctionProduct::find($id);

        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'nullable',
            'brand' => 'nullable',
            'price' => 'required',
            'unit' => 'nullable',
            'made_in' => 'nullable',
            'quantity' => 'nullable|numeric|max:' . $auctionProduct->quantity,
            'delivery_charge' => 'nullable',
        ]);

        $bid = $this->bidService->store($id, $request);

        $this->sendSuccessSMS($bid->id);

        $auction = $auctionProduct->auction;
        $user = $auction->user;
        $auctionCreateduserEmail = $user->email;

        if ($auctionCreateduserEmail) {
            Mail::to($auctionCreateduserEmail)->send(new BidSubmissionSuccessful($bid->id));
        }
        Mail::to($request->user())->send(new BidSubmissionSuccessful($bid->id));

        return response()->json(['message' => 'Success']);
    }

    public function latestBids($id)
    {
        return AuctionBidProduct::where('auction_product_id', $id)
            ->limit(10)
            ->latest()
            ->get();
    }

    private function sendSuccessSMS($bidId) {
        $this->smsService
            ->setNumber(auth()->user()->phone)
            ->setMessage("A bid ". $bidId ." is successfully submitted . Thank you for your bid submission.")
            ->send();
    }

    public function myAuctionProducts($slug)
    {
        $auction = Auction::with(['products.bids'])->where('slug', $slug)->first();

        return view('frontend.my-auction-products', [
            'auction' => $auction,
        ]);
    }

    public function myAuctionWonProducts($slug)
    {
        $auction = Auction::with(['products'])->where('slug', $slug)->first();

        return view('frontend.my-auction-won-products', [
            'auction' => $auction,
        ]);
    }

    public function myAuctionProductBids($slug, $id)
    {
        $product = AuctionProduct::with(['bids.bidder', 'bids.madein'])->find($id);
        // dd($product);
        return view('frontend.my-auction-product-bids', [
            'product' => $product
        ]);
    }

    public function myAuctionProductBidsWinner($slug, $id)
    {
        $product = AuctionProduct::with(['bids.bidder', 'bids.madein', 'winner'])->find($id);
        // dd($product);
        return view('frontend.my-auction-product-bids-winner', [
            'product' => $product
        ]);
    }

    public function myAuctionProductBid($slug, $id, $bid_id)
    {
        $bid = AuctionBidProduct::with('product.auction', 'product.catalogue')
            ->where('auction_product_id', $id)
            ->find($bid_id);

        return view('frontend.my-auction-product-bid', [
            'bid' => $bid
        ]);
    }

    public function setAuctionBidWinner(Request $request)
    {
        $request->validate([
            'bid_id' => 'required',
            'bidder_id' => 'required',
        ]);


        $bid = AuctionBidProduct::with('product.auction')->findOrFail($request->bid_id);
        if ($bid->product->auction->user_id != auth()->user()->id) {
            abort(403);
        }

        $bid->product->winner_id = $request->bidder_id;
        $bid->product->save();
        AuctionProduct::where('id', $request->auction_product_id)->update(['status' => 1]);

        // // $dataconfirm = AuctionBidProduct::where('auction_product_id', $request->auction_product_id)->where('user_id', $request->bidder_id)->where('price', $request->bid_price)->update(['winner_status' => 1]);

            
        $bidProduct = AuctionBidProduct::where('auction_product_id', $request->auction_product_id)
            ->where('user_id', $request->bidder_id)
            ->where('price', $request->bid_price)
            ->orderBy('created_at', 'ASC') 
            ->first(); 

            if ($bidProduct) {
                // Update the record
                $bidProduct->update(['winner_status' => 1]);

                AuctionBidProduct::where('auction_product_id', $request->auction_product_id)
                    ->update(['product_auto_win_status' => 1]);

                session()->flash('message', __('Winner selected, we sent a congratulations mail to winner.'));

                $data = array(
                    'title' => $bidProduct->title,
                    'price' => $bidProduct->price,
                );
                
                $winner_email = User::where('id', $request->bidder_id)->first()->email;
                if(!empty($winner_email)){
                    Mail::send('emails.winner-congratulations', $data, function($message) use ($winner_email) {
                        $message->to($winner_email)
                            ->subject('Congratulations, You are winner');
                    });
                }


            } else {
              session()->flash('message', __('Sorry Something went wrong.'));
            }

        // if ($bidProduct) {
        //     session()->flash('message', __('Winner selection done.'));
        // }else{
        //     session()->flash('message', __('Sorry Something went wrong.'));
        // }

        return redirect()->back();
    }

    public function setAuctionBidStatusUpdate(Request $request)
    {

         AuctionProduct::where('id', $request->auction_product_id)->update(['status' => $request->status]);

        session()->flash('message', __('Your Status Updated.'));

        return redirect()->back();
    }


    public function setAuctionBidAcceptStatusUpdate(Request $request)
    {

         AuctionBidProduct::where('id', $request->auction_product_id)->update(['confirmation_status' => $request->status]);

        session()->flash('message', __('You Accept this Bid.'));

        return redirect()->back();
    }    

    public function setAuctionBidRejectStatusUpdate(Request $request)
    {

         AuctionBidProduct::where('id', $request->auction_product_id)->update(['confirmation_status' => $request->status]);

        session()->flash('message', __('You Reject this Bid.'));

        return redirect()->back();
    }

    public function myAuctionEdit($id)
    {
        $auction = Auction::find($id);

        return view('frontend.my_auction.edit', compact('auction'));
    }
}
