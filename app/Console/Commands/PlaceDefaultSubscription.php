<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\Checkout\SubscriptionService;
use App\Model\User;
use App\Model\Subscription;
use DB;

class PlaceDefaultSubscription extends Command
{
    private $subscriptionService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PlaceDefaultSubscription:placeDefaultSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add weekly menu by default for users with monthly billing cycle';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
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
          $monthlyUsers = User::where('billing_cycle','monthly')->get();
          if(!empty($monthlyUsers)){
            foreach($monthlyUsers as $userDetails){
              DB::enableQueryLog();
                $subscribedData = Subscription::select('order_type_id')->where('user_id',$userDetails->id)->get();
                if(!empty($subscribedData)){
                    foreach ($subscribedData as $subscriptionDetails) {
                        $orderTypeId = $subscriptionDetails['order_type_id'];
                        $dishData = $this->subscriptionService->getDefaultDishList($orderTypeId);
                        echo "<pre/>";
                        print_r($dishData);
exit;
                        $foodPreference = $userDetails->food_preference;
                        $foodQuantity = $userDetails->tiffin_quantity;
                        switch($foodPreference){
                          case 'veg':

                            break;
                          case 'nonveg':

                            break;
                        }
                    }
                }
              }
           }
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }
}
