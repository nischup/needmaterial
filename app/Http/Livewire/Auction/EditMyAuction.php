<?php

namespace App\Http\Livewire\Auction;

use App\Models\Auction;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Services\AuctionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class EditMyAuction extends Component
{
    public $auction, $auction_id, $title, $description, $brand, $unit, $start_time, $end_time;
    public $vat, $included_delivery_cost, $delivery_date;
    public $service_type, $is_open_bid;
    public $comment;

    public function render()
    {
        return view('frontend.livewire.auction.edit-my-auction');
    }

    public function update()
    {
        $this->validate([
            'service_type' => 'required',
            'title' => 'required|unique:auctions,title,'.$this->auction_id,
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'delivery_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            $this->auction->update([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'comment' => $this->comment,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'included_delivery_cost' => $this->included_delivery_cost ? 1 : 0,
                'vat' => $this->vat ? 1 : 0,
                'delivery_date' => $this->delivery_date
            ]);

            session()->flash('message', __('Auction updated successfully.'));
            DB::commit();
        } catch (\Exception $e) {
            session()->flash('error', __('Something went wrong! please try again'));
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            session()->flash('error', __('Something went wrong! please try again'));
            DB::rollback();
            throw $e;
        }

        return redirect()->back();
    }

    public function mount()
    {
        $auction = Auction::find($this->auction_id);
        $this->auction = $auction;

        $this->service_type = $auction->service_type;
        $this->is_open_bid = $auction->is_open_bid;
        $this->title = $auction->title;
        $this->description = $auction->description;
        $this->comment = $auction->comment;
        $this->start_time = $auction->start_time;
        $this->end_time = $auction->end_time;
        $this->included_delivery_cost = $auction->included_delivery_cost;
        $this->vat = $auction->vat;
        $this->delivery_date = $auction->delivery_date;
    }
}
