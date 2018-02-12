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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Contact-Us route
 *
 */
/*route to show the contact us form*/
Route::get('contact-us', 'Contact\ContactController@showContactUsForm')->name('contact-us');
/*route to process the contact us form*/
Route::post('contact-us', 'Contact\ContactController@conatctUs');

/**
 * Order route
 *
 */
/* Route to show the order form*/
Route::get('order/{type}', 'Order\OrderController@showOrderForm')->name('order')->where('type', '[a-z]+')->middleware('auth');
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
    Route::get('dashboard', 'Customer\CustomerController@dashboard')->name('dashboard');

    Route::get('address/add', 'Customer\AddressController@showAddressForm')->name('address-add');
    Route::post('address/add', 'Customer\AddressController@saveAddress')->name('address-add');

    Route::get('address/list', 'Customer\AddressController@listAddress')->name('address-list');

});
