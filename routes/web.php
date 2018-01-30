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

/**
 * Registration route
 *
 */
/*route to show the registration form*/ 
// Route::get('register', function() { return view('customer.register'); });
/*route to process the registration form*/ 
// Route::post('register', ['uses' => 'Customer\CustomerController@register', 'as' => 'register']);

/**
 * Login route
 *
 */
/*route to show the login form*/ 
// Route::get('login', function() { return view('customer.login'); });
/*route to process the login form*/
// Route::post('login', ['uses' => 'Customer\CustomerController@login', 'as' => 'login']);


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
/*route to show the order form*/ 
Route::get('order/{type}', 'Order\OrderController@showOrderForm')->name('order')->where('name', '[a-z]+');
/*route to show the order form*/ 
Route::post('order', 'Order\OrderController@processOrder')->name('processOrder');


/**
 * Customer route
 *
 */

Route::group(['prefix' => 'customer'], function() {

    /*route to show the customer dashboard*/ 
    Route::get('dashboard', 'Customer\CustomerController@dashboard')->name('dashboard');

});
