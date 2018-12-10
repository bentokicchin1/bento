<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultSubscriptionPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        echo "<pre/>";
        print_R($subscription);
        exit;
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.defaultSubscriptionPlaced');
    }
}
