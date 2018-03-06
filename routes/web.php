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
// Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('otp', 'Auth\RegisterController@showOtpForm')->name('showOtpForm');
Route::post('otp', 'Auth\RegisterController@verifyOtp')->name('verifyOtp');

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
    // Route::get('dashboard', 'Customer\CustomerController@dashboard')->name('dashboard');
    Route::get('orders','Customer\CustomerController@orders')->name('orders');

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

/* Admin panel routes */
Route::group(['prefix' => 'admin'], function(){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin-dashboard');

    Route::get('order-type/add', 'Admin\Order\OrderTypeController@showForm')->name('admin-order-type-add');
    Route::post('order-type/add', 'Admin\Order\OrderTypeController@store')->name('admin-order-type-add');
    Route::get('order-type/edit/{id}', 'Admin\Order\OrderTypeController@showForm')->where('id', '[0-9]+')->name('admin-order-type-edit');
    Route::get('order-type/delete/{id}', 'Admin\Order\OrderTypeController@delete')->where('id', '[0-9]+')->name('admin-order-type-delete');
    Route::get('order-type/list', 'Admin\Order\OrderTypeController@index')->name('admin-order-type-list');

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

    Route::get('city/add', 'Admin\DishController@showForm')->name('admin-city-add');
    Route::post('city/add', 'Admin\DishController@store')->name('admin-city-add');
    Route::get('city/edit/{id}', 'Admin\DishController@showForm')->where('id', '[0-9]+')->name('admin-city-edit');
    Route::get('city/delete/{id}', 'Admin\DishController@delete')->where('id', '[0-9]+')->name('admin-city-delete');
    Route::get('city/list', 'Admin\DishController@index')->name('admin-city-list');

    Route::get('sector/add', 'Admin\DishController@showForm')->name('admin-sector-add');
    Route::post('sector/add', 'Admin\DishController@store')->name('admin-sector-add');
    Route::get('sector/edit/{id}', 'Admin\DishController@showForm')->where('id', '[0-9]+')->name('admin-sector-edit');
    Route::get('sector/delete/{id}', 'Admin\DishController@delete')->where('id', '[0-9]+')->name('admin-sector-delete');
    Route::get('sector/list', 'Admin\DishController@index')->name('admin-sector-list');

    //Route::get('dish-type/list', 'Admin\DishType\DishTypeController@index')->name('admin-dishes-list');

});
