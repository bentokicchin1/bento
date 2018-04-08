<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Model\Subscription;
use App\Services\Checkout\OrderService;

class PlaceOrder extends Command
{

      private $orderService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PlaceOrder:placeOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Place Default Orders Daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
          $today = strtolower(date('l'));
          $subscribed = Subscription::where('subscription_items','like','%'.$today.'%')->get();
          if(!empty($subscribed)){
            foreach($subscribed as $subscribedData){
              $subscribedDishes = json_decode($subscribedData->subscription_items,true);
              if(!empty($subscribedDishes) && array_key_exists($today,$subscribedDishes)){
                $orderDetails = array();
                $orderDetails['orderDate'] = date('Y-m-d');
                $orderDetails['user'] = $subscribedData['user_id'];
                $orderDetails['orderTypeId'] = $subscribedData['order_type_id'];
                $orderDetails['shippingAddressId'] = $subscribedData['shipping_address_id'];
                $orderDetails['orderTotalAmount'] = $subscribedDishes[$today]['orderTotalAmount'];
                $orderDetails['items'] = $subscribedDishes[$today]['items'];
                $response = $this->orderService->processSubscriptionData($orderDetails);
              }
            }
          }
          return 'success';
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }


}
