<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
// use App\Mail\YourMail; // Replace with your actual mail class

class SendEmail extends Command
{
    protected $signature = 'send:mail';

    protected $description = 'Send an Mail';

    public function handle()
    {
        // Send the email

        $data = array('data' => 'Corn job testing mail');
        Mail::send('emails.test', $data, function($message){
            $message->to('ahsabbir23@gmail.com')
            ->subject('Hello NeedMaterials find you for mail');
        });

        // Mail::to('ahsabbir.me@gmail.com')->send(new BidSubmissionSuccessful());

        $this->info('Email sent successfully.');

        return Command::SUCCESS;
    }
}
