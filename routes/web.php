<?php

$this->group(['middleware'=>'auth','namespace'=>'Admin','prefix'=>'admin'], function (){
    Route::get('/','AdminController@index')->name('admin.home');
    Route::get('/balance','BalanceController@index')->name('admin.balance');

    Route::get('/deposit','BalanceController@deposit')->name('balance.deposito');
    Route::post('/deposit','BalanceController@depositStore')->name('deposit.store');

    Route::post('/saque','BalanceController@saqueStore')->name('saque.store');
    Route::get('/sacar','BalanceController@sacar')->name('balance.sacar');
    Route::post('/sacar','BalanceController@sacarStore')->name('sacar.store');

    Route::get('/transfer','BalanceController@transfer')->name('balance.transfer');
    Route::post('/transfer-confirm','BalanceController@confirmTransfer')->name('confirm.transfer');
    Route::post('/transfer','BalanceController@transferStore')->name('transfer.store');
});


Route::get('/','Site\SiteController@index')->name('site.home');

Auth::routes();

