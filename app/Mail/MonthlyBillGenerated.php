<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthlyBillGenerated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lastMonth,$user,$orders)
    {
        $this->lastMonth = $lastMonth;
        $this->user = $user;
        $this->orders = $orders;
        echo "<pre/>";
        print_r($this);
        exit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lastMonth = date('M',strtotime('this month'));
        return $this->subject('Bill For The Month Of '.$lastMonth)->view('emails.monthlyBill');
    }
}
