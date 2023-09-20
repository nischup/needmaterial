<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuctionBidProduct;
use App\Models\AuctionProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SellingAuctionWinnerAutoSelect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bidder-auto-select:selling-auction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In this command system will find the highest bidder for my selling auction and select winner autometically within the time frame it can be 1 hour or 1 days or can be 3 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $bidProduct = AuctionBidProduct::with('auction')->where('created_at', '<', Carbon::now()->subMinutes(5))
                ->where('winner_status', 0)
                ->orderBy('price', 'DESC')
                ->orderBy('created_at', 'ASC')
                ->whereHas('auction', function ($query) {
                        $query->where('service_type', '3');
                    })
                ->first(); 


            if ($bidProduct && $bidProduct->product_auto_win_status == 0) {
                $bidProduct->update(['winner_status' => 1]);

                 AuctionBidProduct::where('auction_product_id', $bidProduct->auction_product_id)
                    ->update(['product_auto_win_status' => 1]);

                $winnerId = $bidProduct->user_id;

                AuctionProduct::where('auction_id', $bidProduct->auction_product_id)
                    ->update(['status' => 1, 'winner_id' => $winnerId]);

                $winner_email = User::where('id', $winnerId)->first()->email;

                if (!empty($winner_email)) {
                    $data = array('data' => 'Corn job testing mail');
                    
                    Mail::send('emails.test', $data, function($message) use ($winner_email) {
                        $message->to($winner_email)
                            ->subject('Congratulations !!! You are selected for this bid');
                    });
                    
                }

            }
           $this->info('Winner autometically selected from selling request');
           return Command::SUCCESS;
    }
}
