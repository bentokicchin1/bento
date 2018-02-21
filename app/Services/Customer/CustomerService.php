<?php

/**
 * Service for address related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Customer;

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
            $user->email = $postData['email'];
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

}
