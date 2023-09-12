<?php

namespace App\Mail;

use App\Models\AuctionBidProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidSubmissionSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public $bid;

    /**
     * Create a new message instance.
     *
     * @param $bid
     */
    public function __construct($bidId)
    {
        $this->bid = AuctionBidProduct::with('product.auction','product.catalogue','product.thumbnail')->find($bidId);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Bid success')
            ->view('emails.bid_success');
    }
}
