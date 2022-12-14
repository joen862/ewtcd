<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RPCController;
use App\Http\Controllers\AddressController;

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

Route::get('/', [DashboardController::class,'index']);
Route::get('/wallets', [DashboardController::class,'wallets']);
Route::get('/validators', [DashboardController::class,'validators']);

//Route::get('/rpc', [RPCController::class,'index']);

Route::get('/address/{address}', [AddressController::class,'show']);
