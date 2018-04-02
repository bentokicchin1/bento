<?php

/**
 * Service for address related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Customer;

use App\Model\Feedback;
use App\Model\Order;
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
            $user->name = $postData['name'];
            $user->mobile_number = $postData['mobile_number'];
            $user->billing_cycle = $postData['billing_cycle'];
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
            $feedbackObj = new Feedback;
            $feedbackObj->user_id = Auth::id();
            $feedbackObj->value = $postData->value;
            $feedbackObj->save();
            return 'success';
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }



}
