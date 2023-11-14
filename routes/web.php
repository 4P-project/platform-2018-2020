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

// Auth routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('/logout', function () {
    Auth::logout();

    return redirect('/login');
});

// Frontend Controller
Route::get('/', 'IndexController@index');

// Account Controller
Route::group(['prefix' => 'account'], function () {
    Route::get('', 'AccountController@dashboard');
    Route::get('verify', 'AccountController@verify');
    Route::get('edit', 'AccountController@edit');
    Route::post('update/{user}', 'AccountController@update')->name('account.update');
    Route::post('getPublicKey', 'AccountController@getPublicKey');

    Route::group(['prefix' => 'verify'], function () {
        Route::get('personal', 'AccountController@verifyPersonal');
        Route::get('corporate', 'AccountController@verifyCorporate');
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('add', 'AccountController@addEmployee');
        Route::get('list', 'AccountController@listEmployee');
        Route::get('ajax-list', 'AccountController@employeeAjaxList');
    });

    Route::get('apicredentials', 'AccountController@apicredentials');

    Route::get('wallet', 'AccountController@wallet');

    // KYC controller
    Route::post('/userkycs', 'UserkycsController@store');

    // Documents controller
    Route::group(['prefix' => 'documents'], function () {
        Route::get('', 'DocumentController@index');
        Route::get('send', 'DocumentController@send');
        Route::post('saveFile', 'DocumentController@saveFile');
    });

    Route::get('payment', 'AccountController@payment');
    Route::get('processPayment', 'AccountController@processPayment');
    Route::get('invoice/{invoice}', 'AccountController@downloadInvoice');
    Route::get('orders', 'AccountController@orders');
});

// Admin controller
Route::group(['prefix' => env('ADMIN_ROUTE', 'admin')], function () {
    Route::get('', 'AdminController@dashboard');
    Route::get('kyc/pending', 'AdminController@pending');

    // KYC controller
    Route::get('kyc/filterdata', 'UserkycsController@filterdata');
    Route::get('kyc/{kyc}', 'UserkycsController@show');
    Route::put('kyc/update/{kyc}', 'UserkycsController@update');
});

// Mail controller
Route::group(['prefix' => 'mail'], function () {
    Route::post('employee/invite', 'MailController@invite');
    Route::get('confirm', 'MailController@confirm');
    Route::post('admin',  'MailController@mailToAdmin');
});

// Transaction Controller
Route::group(['prefix' => 'transaction'], function () {
    Route::post('sign', 'TransactionController@sign');
});

// Extension Controller
Route::group(['prefix' => 'extension'], function () {
    Route::post('sendPublicKey', 'ExtensionController@savePublicKey');
});
