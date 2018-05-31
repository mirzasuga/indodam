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
    return view('welcome');
})->name('welcome');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Change Password Routes...
Route::get('change-password', 'Auth\ChangePasswordController@show')->name('password.change');
Route::patch('change-password', 'Auth\ChangePasswordController@update')->name('password.change');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Guest Routes
 */
Route::get('register', [
    'as' => 'guest.register',
    'uses' => 'GuestController@index'
]);
Route::post('register', [
    'as' => 'guest.post_register',
    'uses' => 'GuestController@create'
]);

Route::group(['middleware' => 'auth'], function () {
    /**
     * User Transactions Routes
     */
    Route::get('profile/{user}/transactions', 'Users\TransactionsController@index')->name('profile.transactions.index');
    Route::post('profile/{sender}/transfer-to/{receiver}', 'Users\TransactionsController@transfer')->name('profile.transactions.transfer');

    /**
     * User Members Routes
     */
    Route::get('profile/{user}/members', 'Users\MembersController@index')->name('profile.members.index');
    Route::get('profile/{user}/members/create', 'Users\MembersController@create')->name('profile.members.create');
    Route::post('profile/{user}/members', 'Users\MembersController@store')->name('profile.members.store');

    /**
     * User Cloud Servers Routes
     */
    Route::get('profile/{user}/cloud-servers', 'Users\CloudServersController@index')->name('profile.cloud-servers.index');

    /**
     * User Profile Page
     */
    Route::get('profile/{user}', 'ProfileController@show')->name('profile.show');

    /**
     * Wallet Routes
     */
    Route::get('wallet',[
        'as' => 'wallet.index',
        'uses' => 'WalletController@index'
    ]);

    /**
     * Withdraws
     */
    Route::get('profile/{user}/withdraw',[
        'as' => 'withdraw.index',
        'uses' => 'WithdrawRequestController@index'
    ]);
    Route::post('withdraw', [
        'as' => 'withdraw.store',
        'uses' => 'WithdrawRequestController@store'
    ]);

    Route::get('withdraw/verify/{token_request}', [
        'as' => 'withdraw.verify',
        'uses' => 'WithdrawRequestController@verify'
    ]);
    Route::post('withdraw/approve/{id}', [
        'as' => 'withdraw.approve',
        'uses' => 'WithdrawRequestController@approve'
    ]);

    /**
     * MINING
     */
    Route::get('profile/{user}/mining', [
        'uses' => 'MiningController@index',
        'as' => 'mining.index'
    ]);
    Route::post('mining',[
        'uses' => 'MiningController@store',
        'as' => 'mining.store'
    ]);
});
Route::group(['middleware' => 'role:1'], function () {
    /**
     * User Transactions Routes
     */
    Route::patch('profile/{user}/wallet-update', 'UsersController@walletUpdate')->name('profile.wallet-update');
    Route::post('profile/{user}/deposit', 'Users\TransactionsController@deposit')->name('profile.transactions.deposit');
    Route::post('profile/{user}/withdraw', 'Users\TransactionsController@withdraw')->name('profile.transactions.withdraw');

    /**
     * Users Routes
     */
    Route::patch('users/{user}/activate', 'UsersController@activate')->name('users.activate');
    Route::delete('users/{user}/suspend', 'UsersController@suspend')->name('users.suspend');
    Route::resource('users', 'UsersController', ['except' => ['show']]);

    /**
     * Transactions Routes
     */
    Route::get('transactions', 'TransactionsController@index')->name('transactions.index');

    /**
     * Packages Routes
     */
    Route::resource('packages', 'PackagesController');

    /*
     * Backup Restore Database Routes
     */
    Route::post('backups/upload', ['as' => 'backups.upload', 'uses' => 'BackupsController@upload']);
    Route::post('backups/{fileName}/restore', ['as' => 'backups.restore', 'uses' => 'BackupsController@restore']);
    Route::get('backups/{fileName}/dl', ['as' => 'backups.download', 'uses' => 'BackupsController@download']);
    Route::resource('backups', 'BackupsController', ['except' => ['create', 'show', 'edit']]);

    /**
     * Site Options Routes
     */
    Route::get('options', ['as' => 'options.page-1', 'uses' => 'OptionsController@page1']);
    Route::patch('options/save-1', ['as' => 'options.save-1', 'uses' => 'OptionsController@save1']);
});
