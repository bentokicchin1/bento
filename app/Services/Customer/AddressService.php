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
            if ( isset($addressParams['default']) && $addressParams['default'] == 1) {
                Address::where('user_id', $userId)
                    ->where('default', 1)
                    ->update(['default' => 0]);
            }

            /*  */
            if(!empty($addressParams['id'])){
                $addressObj = Address::find($addressParams['id']);
            }else{
                $addressObj = new Address;
            }
            $addressObj->user_id = $userId;
            $addressObj->order_type_id = $addressParams['order_type_id'];
            $addressObj->address_type = $addressParams['address_type'];
            $addressObj->name = $addressParams['name'];
            $addressObj->location = $addressParams['location'];
            $addressObj->area = $addressParams['area'];
            $addressObj->sector = $addressParams['sector'];
            $addressObj->city = $addressParams['city'];
            $addressObj->state = $addressParams['state'];
            $addressObj->pincode = $addressParams['pincode'];
            $addressObj->default = $addressParams['default']?? 0;
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
        return  Address::where('user_id', $userId)
                        ->with('city')
                        ->with('area')
                        ->with('areaLocation')
                        ->with('orderType')
                        ->get()->toArray();
    }

    public function getAddressById($addressId){
        return Address::where('id', $addressId)
                        ->with('city')
                        ->with('area')
                        ->with('areaLocation')
                        ->with('orderType')->first()->toArray();
    }

    public function deleteAddress($addressId){
        Address::destroy($addressId);
    }
}
