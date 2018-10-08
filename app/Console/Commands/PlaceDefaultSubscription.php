<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\Checkout\SubscriptionService;
use App\Services\Customer\AddressService;
use App\Model\User;
use App\Model\Subscription;
use DB;

class PlaceDefaultSubscription extends Command
{
        private $addressService;
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
    public function __construct(SubscriptionService $subscriptionService,AddressService $addressService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->addressService = $addressService;
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

          DB::enableQueryLog();
          $monthlyUsers = User::with('address')->where('billing_cycle','monthly')->get()->toArray();
          if(!empty($monthlyUsers)){
            foreach($monthlyUsers as $userDetails){
                $userId = $userDetails['id'];
                $foodPreference = $userDetails['food_preference'];
                $foodQuantity = $userDetails['tiffin_quantity'];

                if(!empty($userDetails['address'])){
                  foreach ($userDetails['address'] as $address) {
                    $orderTypeId = $address['order_type_id'];
                // $subscribedData = Subscription::select('order_type_id')->where('user_id',$userId)->get();
                // if(!empty($subscribedData)){
                //     foreach ($subscribedData as $subscriptionDetails) {
                        $defaultData = array();
                        // $orderTypeId = $subscriptionDetails->order_type_id;
                        $dishData = $this->subscriptionService->getDefaultDishList($orderTypeId);
                        if(!empty($dishData)){
                          foreach ($dishData as $day => $details) {
                            if(!empty($details['items'])){
                              foreach ($details['items'] as $dishType => $dishDetails) {
                                switch($foodPreference){
                                  case 'veg':
                                        $vegHalfDefault = config('constants.DEFAULT_HALF_VEG_TIFFIN');
                                        if(!in_array($dishType,$vegHalfDefault)  && $foodQuantity=='half'){
                                          unset($dishData[$day]['items'][$dishType]);
                                        }else if($dishDetails['food_type']=='nonveg'){
                                          unset($dishData[$day]['items'][$dishType]);
                                        }
                                    break;
                                  case 'nonveg':
                                        $nonVegHalfDefault = config('constants.DEFAULT_HALF_NONVEG_TIFFIN');
                                        if(date('l')=='wednesday' || date('l')=='friday'){
                                          if(!in_array($dishType,$nonVegHalfDefault) && $foodQuantity=='half'){
                                            unset($dishData[$day]['items'][$dishType]);
                                          }else if($dishDetails['food_type']=='veg'){
                                            unset($dishData[$day]['items'][$dishType]);
                                          }
                                        }else{
                                          $vegHalfDefault = config('constants.DEFAULT_HALF_VEG_TIFFIN');
                                          if(!in_array($dishType,$vegHalfDefault)  && $foodQuantity=='half'){
                                            unset($dishData[$day]['items'][$dishType]);
                                          }else if($dishDetails['food_type']=='nonveg'){
                                            unset($dishData[$day]['items'][$dishType]);
                                          }
                                        }
                                    break;
                                }
                              }
                            }
                          }
                          $defaultData['subscriptionItems'] = json_encode($dishData);
                          $defaultData['orderTypeId'] = $orderTypeId;
                          $address = $this->addressService->getAddressByUserOrder($userId,$orderTypeId);
                          $defaultData['shippingAddressId'] = $address->id;
                          $result = $this->subscriptionService->processDefaultSubscription($defaultData,$userId);
                          echo $result;
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
