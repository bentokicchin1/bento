<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// abort(404);
// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/', function () {
  if(Auth::user() && Auth::user()->billing_cycle=='monthly'){
    return view('subscription.subscriptionType');
  }else{
    return view('home');
  }
})->name('home');

Route::get('otp', 'Auth\RegisterController@showOtpForm')->name('showOtpForm');
Route::post('otp', 'Auth\RegisterController@verifyOtp')->name('verifyOtp');

/**
 * Contact-Us route
 *
 */
/*route to show the contact us form*/
Route::get('contact-us', 'Contact\ContactController@showContactUsForm')->name('contact-us');
/*route to process the contact us form*/
Route::post('contact-us', 'Contact\ContactController@conatctUs');

/**
 * Feedback route
 *
 */
/*route to show the feedback form*/
Route::get('feedback', 'Customer\FeedbackController@showFeedbackForm')->name('feedback')->middleware('auth');
/*route to process the feedback form*/
Route::post('feedback', 'Customer\FeedbackController@store')->name('store-feedback')->middleware('auth');

/**
 * Order route
 *
 */
/* Route to show the order form*/
Route::get('order/{type}', 'Order\OrderController@showOrderForm')->name('order')->where('type', '[a-z]+');
/* Route to show address select and order summary page*/
Route::post('checkout', 'Order\OrderController@addressSelect')->name('addressSelect')->middleware('auth');
/* get method used when user redirect to checkout page after adding new address */
Route::get('checkout', 'Order\OrderController@addressSelect')->name('addressSelect')->middleware('auth');
/* Route for order processing */
Route::post('summary', 'Order\OrderController@processOrder')->name('processOrder')->middleware('auth');

Route::get('confirmation', 'Order\OrderController@confirmOrder')->name('confirmation')->middleware('auth') ;
/**
 * Subscription Order route
 *
 */

/* Route to show subscription order type form [Breakfast, Lunch, Dinner]*/
Route::get('subscription', 'Order\SubscriptionController@showSubscriptionOrderTypeForm')->name('subscriptionType')->middleware('auth');
/* Route to show subscription form */
Route::get('subscription/{type}', 'Order\SubscriptionController@showSubscriptionForm')->name('subscription')->where('type', '[a-z]+')->middleware('auth');
/* Route to show address select and order summary page */
Route::post('subscribe/checkout', 'Order\SubscriptionController@addressSelect')->name('subscriptionAddressSelect')->middleware('auth');
/* get method used when user redirect to checkout page after adding new address */
Route::get('subscribe/checkout', 'Order\SubscriptionController@addressSelect')->name('subscriptionAddressSelect')->middleware('auth');
/* Route for order processing */
Route::post('subscribe/summary', 'Order\SubscriptionController@processOrder')->name('subscriptionProcessOrder')->middleware('auth');

Route::get('subscribe/confirmation', 'Order\SubscriptionController@confirmSubscription')->name('subscriptionConfirmation')->middleware('auth') ;

/**
 * Customer route
 *
 */

Route::group(['prefix' => 'customer', 'middleware' => 'auth'], function () {

    /*route to show the customer dashboard*/
    // Route::get('dashboard', 'Customer\CustomerController@dashboard')->name('dashboard');
    Route::get('orders','Customer\CustomerController@orders')->name('orders');
    /* Route to cancel the order*/
    Route::get('order/cancel/{id}', 'Customer\CustomerController@cancelOrder')->name('orderCancel')->where('id', '[0-9]+');

    Route::get('address/add', 'Customer\AddressController@showAddressForm')->name('address-add');
    Route::post('address/add', 'Customer\AddressController@store')->name('address-add');

    Route::get('address/edit/{id}', 'Customer\AddressController@showAddressForm')->where('id', '[0-9]+')->name('address-edit');

    Route::get('address/delete/{id}', 'Customer\AddressController@delete')->where('id', '[0-9]+')->name('address-delete');

    Route::get('address', 'Customer\AddressController@index')->name('address');

    /* Ferch profile page */
    Route::get('profile', 'Customer\CustomerController@profile')->name('profile');

    Route::post('profile/update-info', 'Customer\CustomerController@updateUserInfo')->name('update-info');

    Route::post('profile/change-password', 'Customer\CustomerController@changePassword')->name('change-password');

});


Route::get('admin/login','Admin\LoginController@showLoginForm')->name('admin-login');
Route::post('admin/login','Admin\LoginController@login');
Route::post('admin/logout', 'Admin\LoginController@logout')->name('admin-logout');
Route::post('admin/password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin-password-email');
Route::get('admin/password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin-password-request');
Route::post('admin/password/reset','Admin\ResetPasswordController@reset');
Route::get('admin/password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin-password-reset');

/* Admin panel routes */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function(){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin-dashboard');
    Route::get('user/add', 'Admin\UserController@showForm')->name('admin-user-add');
    Route::post('user/add', 'Admin\UserController@store')->name('admin-user-add');
    Route::get('user/edit/{id}', 'Admin\UserController@showForm')->where('id', '[0-9]+')->name('admin-user-edit');
    Route::get('user/delete/{id}', 'Admin\UserController@delete')->where('id', '[0-9]+')->name('admin-user-delete');
    Route::get('user/list', 'Admin\UserController@index')->name('admin-user-list');
    Route::get('user/order/{id}', 'Admin\UserController@order')->where('id', '[0-9]+')->name('admin-user-order');

    Route::get('order-type/add', 'Admin\OrderTypeController@showForm')->name('admin-order-type-add');
    Route::post('order-type/add', 'Admin\OrderTypeController@store')->name('admin-order-type-add');
    Route::get('order-type/edit/{id}', 'Admin\OrderTypeController@showForm')->where('id', '[0-9]+')->name('admin-order-type-edit');
    Route::get('order-type/delete/{id}', 'Admin\OrderTypeController@delete')->where('id', '[0-9]+')->name('admin-order-type-delete');
    Route::get('order-type/list', 'Admin\OrderTypeController@index')->name('admin-order-type-list');

    Route::get('dish-type/add', 'Admin\DishTypeController@showForm')->name('admin-dish-type-add');
    Route::post('dish-type/add', 'Admin\DishTypeController@store')->name('admin-dish-type-add');
    Route::get('dish-type/edit/{id}', 'Admin\DishTypeController@showForm')->where('id', '[0-9]+')->name('admin-dish-type-edit');
    Route::get('dish-type/delete/{id}', 'Admin\DishTypeController@delete')->where('id', '[0-9]+')->name('admin-dish-type-delete');
    Route::get('dish-type/list', 'Admin\DishTypeController@index')->name('admin-dish-type-list');

    Route::get('dish/add', 'Admin\DishController@showForm')->name('admin-dish-add');
    Route::post('dish/add', 'Admin\DishController@store')->name('admin-dish-add');
    Route::get('dish/edit/{id}', 'Admin\DishController@showForm')->where('id', '[0-9]+')->name('admin-dish-edit');
    Route::get('dish/delete/{id}', 'Admin\DishController@delete')->where('id', '[0-9]+')->name('admin-dish-delete');
    Route::get('dish/list', 'Admin\DishController@index')->name('admin-dish-list');

    Route::get('area/add', 'Admin\AreaController@showForm')->name('admin-area-add');
    Route::post('area/add', 'Admin\AreaController@store')->name('admin-area-add');
    Route::get('area/edit/{id}', 'Admin\AreaController@showForm')->where('id', '[0-9]+')->name('admin-area-edit');
    Route::get('area/delete/{id}', 'Admin\AreaController@delete')->where('id', '[0-9]+')->name('admin-area-delete');
    Route::get('area/list', 'Admin\AreaController@index')->name('admin-area-list');

    Route::get('location/add', 'Admin\LocationController@showForm')->name('admin-location-add');
    Route::post('location/add', 'Admin\LocationController@store')->name('admin-location-add');
    Route::get('location/edit/{id}', 'Admin\LocationController@showForm')->where('id', '[0-9]+')->name('admin-location-edit');
    Route::get('location/delete/{id}', 'Admin\LocationController@delete')->where('id', '[0-9]+')->name('admin-location-delete');
    Route::get('location/list', 'Admin\LocationController@index')->name('admin-location-list');

    Route::get('menu/add', 'Admin\WeeklymenuController@showForm')->name('admin-menu-add');
    Route::post('menu/add', 'Admin\WeeklymenuController@store')->name('admin-menu-add');

    Route::get('order/add', 'Admin\OrderController@showForm')->name('admin-order-add');
    Route::post('order/add', 'Admin\OrderController@store')->name('admin-order-add');
    Route::post('order/getDishList', 'Admin\OrderController@getDishList')->name('admin-order-dishList');
    Route::get('order/getAddress', 'Admin\OrderController@getUserAddress')->name('admin-order-userAddress');
    Route::get('order/edit/{id}', 'Admin\OrderController@showForm')->where('id', '[0-9]+')->name('admin-order-edit');
    Route::get('order/delete/{id}', 'Admin\OrderController@delete')->where('id', '[0-9]+')->name('admin-order-delete');
    Route::get('order/list', 'Admin\OrderController@index')->name('admin-order-list');

    Route::get('billpayment/add', 'Admin\BillingController@showForm')->name('admin-billpayment-add');
    Route::post('billpayment/add', 'Admin\BillingController@store')->name('admin-billpayment-add');
    Route::get('billpayment/edit/{id}', 'Admin\BillingController@showForm')->where('id', '[0-9]+')->name('admin-billpayment-edit');
    Route::get('billpayment/delete/{id}', 'Admin\BillingController@delete')->where('id', '[0-9]+')->name('admin-billpayment-delete');
    Route::get('billpayment/list', 'Admin\BillingController@index')->name('admin-billpayment-list');
});
