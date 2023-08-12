<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);

  
Route::middleware(['api.auth'])->group(function () {

/* Query customers */
Route::get('/user', [ClientController::class, 'indexClient']);

/* Query customer by id */
Route::get('/user/{id}', [ClientController::class, 'showClient']);

/* Save customer */
Route::post('/store-client', [ClientController::class, 'storeClient']);

/* Update customer by id */
Route::put('/update-client/{id}', [ClientController::class, 'updateClient']);

/* Delet customer by id */
Route::delete('/delete-client/{id}', [ClientController::class, 'deleteClient']);

});
