<?php

use Illuminate\Http\Request;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProvinsiController;
use App\Http\Controllers\Api\ApiController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//provinsi
Route::get('provinsi',[ProvinsiController::class,'index']);
Route::post('provinsi/store',[ProvinsiController::class,'store']);
Route::get('provinsi/{id?}',[ProvinsiController::class,'show']);
Route::post('provinsi/update/{id?}',[ProvinsiController::class,'update']);
Route::delete('provinsi/{id?}',[ProvinsiController::class,'destroy']);

//kasus
Route::get('indonesia',[ApiController::class, 'indonesia']);
Route::get('provinsikasus2/{id}',[ApiController::class, 'provinsi']);
Route::get('provinsikasus2',[ApiController::class, 'provinsikasus']);
Route::get('hari',[ApiController::class, 'hari']);
Route::get('indonesia/kota',[ApiController::class, 'kota']);
Route::get('indonesia/kecamatan',[ApiController::class, 'kecamatan']);
Route::get('indonesia/kelurahan',[ApiController::class, 'kelurahan']);
Route::get('rw', [ApiController::class,'rw']);
Route::get('global',[ApiController::class, 'global']);
