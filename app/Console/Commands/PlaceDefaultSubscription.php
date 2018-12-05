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
          $lastSunday = date('Y-m-d',strtotime('last sunday'));
          $monthlyUsers = User::with('address')
                          ->where('billing_cycle','monthly')
                          ->where("users.id", 20)
                          ->where("users.deleted_at", NULL)
                          ->get()->toArray();
          if(!empty($monthlyUsers)){
            foreach($monthlyUsers as $userDetails){
                  $userId = $userDetails['id'];
                  $foodPreference = $userDetails['food_preference'];
                  $foodQuantity = $userDetails['tiffin_quantity'];
                  if(!empty($userDetails['address']) && !empty($foodPreference) && !empty($foodQuantity)) {
                    foreach ($userDetails['address'] as $address) {
                        $orderTypeId = $address['order_type_id'];
                        $notSubscribed = Subscription::where('user_id',$userDetails['id'])
                              ->where('updated_at','>=',$lastSunday)
                              ->where("subscriptions.deleted_at", NULL)
                              ->where("subscriptions.order_type_id", $orderTypeId)->get()->toArray();
                        if(empty($notSubscribed)){
                          $defaultData = array();
                          $dishData = $this->subscriptionService->getDefaultDishList($orderTypeId);
                          if(!empty($dishData)){
                            foreach ($dishData as $day => $details) {
                              $orderTotalAmount = $details['orderTotalAmount'];
                              if(!empty($details['items'])){
                                foreach ($details['items'] as $dishType => $dishDetails) {
                                  switch($foodPreference){
                                    case 'veg':
                                          $vegHalfDefault = config('constants.DEFAULT_HALF_VEG_TIFFIN');
                                          if(!in_array($dishType,$vegHalfDefault)  && $foodQuantity=='half'){
                                            if($dishType=='others'){
                                                foreach ($dishData[$day]['items'][$dishType] as $k => $other) {
                                                    $orderTotalAmount -= $other['total_price'];
                                                    unset($dishData[$day]['items'][$dishType][$k]);
                                                }
                                                unset($dishData[$day]['items'][$dishType]);
                                            }else{
                                              $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                              unset($dishData[$day]['items'][$dishType]);
                                            }
                                          }else if(isset($dishDetails['food_type']) && $dishDetails['food_type']=='nonveg'){
                                            $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                            unset($dishData[$day]['items'][$dishType]);
                                          }
                                      break;
                                    case 'nonveg':
                                          $nonVegHalfDefault = config('constants.DEFAULT_HALF_NONVEG_TIFFIN');
                                          if(date('l',strtotime($day))=='Wednesday' || date('l',strtotime($day))=='Friday'){
                                            if(!in_array($dishType,$nonVegHalfDefault) && $foodQuantity=='half'){
                                              if($dishType=='others'){
                                                  foreach ($dishData[$day]['items'][$dishType] as $k => $other) {
                                                      $orderTotalAmount -= $other['total_price'];
                                                      unset($dishData[$day]['items'][$dishType][$k]);
                                                  }
                                                  unset($dishData[$day]['items'][$dishType]);
                                              }else{
                                                $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                                unset($dishData[$day]['items'][$dishType]);
                                              }
                                            }else if(isset($dishDetails['food_type']) && ($dishDetails['food_type']=='veg')) {
                                              $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                              unset($dishData[$day]['items'][$dishType]);
                                            }
                                          }else{
                                            $vegHalfDefault = config('constants.DEFAULT_HALF_VEG_TIFFIN');
                                            if(!in_array($dishType,$vegHalfDefault)  && $foodQuantity=='half'){
                                              if($dishType=='others'){
                                                  foreach ($dishData[$day]['items'][$dishType] as $k => $other) {
                                                      $orderTotalAmount -= $other['total_price'];
                                                      unset($dishData[$day]['items'][$dishType][$k]);
                                                  }
                                                  unset($dishData[$day]['items'][$dishType]);
                                              }else{
                                                $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                                unset($dishData[$day]['items'][$dishType]);
                                              }
                                            }else if(isset($dishDetails['food_type']) && $dishDetails['food_type']=='nonveg'){
                                              $orderTotalAmount -= $dishData[$day]['items'][$dishType]['total_price'];
                                              unset($dishData[$day]['items'][$dishType]);
                                            }
                                          }
                                      break;
                                  }
                                }
                              }
                              $dishData[$day]['orderTotalAmount'] = $orderTotalAmount;
                            }
                            echo "<pre/>";
                            print_r($dishData);
                            exit;
                            $defaultData['subscriptionItems'] = json_encode($dishData);
                            $defaultData['orderTypeId'] = $orderTypeId;
                            $address = $this->addressService->getAddressByUserOrder($userId,$orderTypeId);
                            $defaultData['shippingAddressId'] = $address->id;
                            $result = $this->subscriptionService->processDefaultSubscription($defaultData,$userId);
                          }
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
