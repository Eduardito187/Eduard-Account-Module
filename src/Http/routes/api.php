<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Eduard\Account\Http\Controllers\Api\Customer\Account;
use Eduard\Account\Http\Controllers\Api\System;
use Eduard\Account\Http\Middleware\AdminValidateToken;
use Eduard\Account\Http\Controllers\Api\System\Core;
use Eduard\Account\Http\Middleware\CustomValidateToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([CustomValidateToken::class])->group(function () {
    Route::controller(Account::class)->group(function() {
        Route::post('account/dashboard-data', 'getDashboardData');
        Route::post('account/infraestructure-data', 'getInfraestructureData');
        Route::post('account/aplication-data', 'getAplicationData');
        Route::post('account/customer-information', 'getCustomerInformation');
        Route::post('account/login', 'customerValidateLogin');
        Route::post('account/reset-password', 'customerResetPassword');
        Route::post('account/generate-password', 'generatePassword');
        Route::post('account/close-session', 'closeSession');
        Route::post('account/my-account', 'getMyAccount');
        Route::post('account/team-users', 'getUsersTeam');
        Route::post('account/team-support', 'getSupportTeam');
        Route::post('account/team-index', 'getAllIndex');
        Route::post('account/all-keys', 'getAllKeys');
        Route::post('account/notification-config', 'getConfigNotifications');
        Route::post('account/set-config-notification', 'setConfigNotifications');
        Route::post('account/contact-config', 'getConfigContacts');
        Route::post('account/set-config-contact', 'setConfigContacts');
    });

    Route::controller(System::class)->group(function() {
        Route::get('system/getAllIp', 'getAllIp');
        Route::get('system/getAllConfig', 'getAllConfig');
        Route::get('system/getAllMigrations', 'getAllMigrations');
        Route::get('system/getAllRestictIp', 'getAllRestictIp');
        Route::get('system/getAllRestictDomain', 'getAllRestictDomain');
    });
});

Route::middleware([AdminValidateToken::class])->group(function () {
    Route::controller(Core::class)->group(function() {
        Route::post('system/createClient', 'createClient');
    });
});