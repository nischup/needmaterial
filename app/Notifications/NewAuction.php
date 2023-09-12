<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;


class NewAuction extends Notification
{
    use Queueable;


    public $order;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $url = url("/auctions/{$this->auction->id}");

        return (new WhatsAppMessage)
            ->content("New {$url} auction {$this->auction->title} has arrived in your location. details: {$url}");
    }
}
