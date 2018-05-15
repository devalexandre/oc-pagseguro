<?php

Route::group(['prefix' => 'pagseguro'], function () {

    Route::post('notification','\Indev\Pagseguro\Components\Pagseguro@onReturn');

    Route::get('return','\Indev\Pagseguro\Components\Pagseguro@onReturn');



});
