<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthlyBillGenerated extends Mailable
{
    use Queueable, SerializesModels;
    public $lastMonth;
    public $user;
    public $orders;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$orders)
    {
        $this->user = $user;
        $this->orders = $orders;
        $this->lastMonth = date('J',strtotime('this month'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lastMonth = date('J',strtotime('this month'));
        return $this->subject('Bill For The Month Of '.$lastMonth)->view('emails.monthlyBill');
    }
}
