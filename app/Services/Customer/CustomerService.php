<?php

/**
 * Service for address related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Customer;

use App\Model\Feedback;
use App\Model\Order;
use App\Model\Subscription;
use DB;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\Exception;

class CustomerService
{

    private $order;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function updateUserInfo($postData)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $userId = Auth::id();
            $user->name = $postData['name'];
            $user->mobile_number = $postData['mobile_number'];
            $user->billing_cycle = $postData['billing_cycle'];
            if($postData['billing_cycle']=='monthly'){
              $user->food_preference = $postData['food_preference'];
              $user->tiffin_quantity = $postData['tiffin_quantity'];
            }else{
              $this->removeSubscription($userId);
              $user->food_preference = NULL;
              $user->tiffin_quantity = NULL;
            }
            $user->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }

    }

    public function changePassword($postData)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->password = bcrypt($postData['new_password']);
            $user->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }
    }

    public function storeFeedback($postData)
    {
        try {
          $monthlyUsers = User::with('address')
                          ->where('billing_cycle','monthly')
                          ->where("users.deleted_at", NULL)
                          ->get()->toArray();
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }

    public function removeSubscription($userId)
    {
        Subscription::where("user_id",$userId)->firstOrFail()->delete();
    }


}
