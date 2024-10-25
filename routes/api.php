<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PathologyTestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function(){
    Route::post('get-access-token', [AuthController::class, 'getAccessToken']);
    Route::post('user-login-or-register', [AuthController::class, 'userLoginorRegister']);
    Route::post('search-all', [LaboratoryController::class, 'searchAll']);
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //ORDER CONTROLLER
        Route::post('get-active-orders', [OrderController::class, 'getActiveOrders']);
        Route::post('pickup-order', [OrderController::class, 'updateOrderToPickup']);
        Route::post('get-order-overview', [OrderController::class, 'orderOverView']);
        Route::post('create-order', [OrderController::class, 'createOrder']);
        Route::post('verify-payment', [OrderController::class, 'verifyPayment']);
        
        //WALLET CONTROLLER
        Route::post('get-wallet-data', [WalletController::class, 'getTransactions']);
        Route::post('add-wallet-balance', [WalletController::class, 'addWalletBalanceCollectorApi']);
        
        //LABORATORY CONTROLLER
        Route::post('get-nearby-labs', [LaboratoryController::class, 'getNearbyLabs']);
        
        //AUTH CONTROLLER
        Route::post('update-patient-profile', [AuthController::class, 'updatePatientProfile']);
        
        //PATHOLOGY TEST CONTROLLER
        Route::post('get-pathology-tests', [PathologyTestController::class, 'getPathologyTest']);
        
    });
    Route::get('test', [AuthController::class, 'test']);
});