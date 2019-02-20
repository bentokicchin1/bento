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
    public $billAmount;
    public $pendingBill;
    public $outstanding_bill;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifyArray)
    {
        $this->user = $notifyArray['user'];
        $this->orders = $notifyArray['orders'];
        $this->billAmount = $notifyArray['billAmount'];
        $this->pendingBill = $notifyArray['pendingBill'];
        $this->outstanding_bill = $notifyArray['outstanding_bill'];
        $this->lastMonth = date('F',strtotime('first day of last month'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lastMonth = date('F',strtotime('first day of last month'));
        return $this->subject('Bill For The Month Of '.$lastMonth)->view('emails.monthlyBill');
    }
}
