<?php

/**
 * Service for address related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Customer;

use App\Model\CustomerAddresse as Address;
use DB;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\Exception;

class AddressService
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function saveAddress($postRequest)
    {
        return $this->insertAddress($postRequest);
    }

    /**
     * Insert address in table
     */
    private function insertAddress($addressParams)
    {
        DB::beginTransaction();
        $userId = Auth::id();
        try {
            if ($addressParams['setAsDefault'] == 1) {
                Address::where('user_id', $userId)
                    ->where('default', 1)
                    ->update(['default' => 0]);
            }
            $addressObj = new Address;
            $addressObj->user_id = $userId;
            $addressObj->order_type_id = $addressParams['orderTypeId'];
            $addressObj->address_type = $addressParams['addressTypes'];
            $addressObj->name = $addressParams['name'];
            $addressObj->location = $addressParams['location'];
            $addressObj->area = $addressParams['area'];
            $addressObj->city = $addressParams['city'];
            $addressObj->state = $addressParams['state'];
            $addressObj->pincode = $addressParams['pincode'];
            $addressObj->default = $addressParams['setAsDefault'];
            $addressObj->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }
    }

    public function getAddressList(){
        $userId = Auth::id();
        return Address::all()->where('user_id', $userId)->toArray();
    }

    public function getAddressById($addressId){
        return Address::all()->where('id', $addressId)->first()->toArray();
    }
}
