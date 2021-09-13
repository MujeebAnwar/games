<?php

use App\Http\Controllers\APi\GameController;
use App\Http\Controllers\APi\PcController;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Home Data
Route::get('home',[GameController::class,'homeData']);

// Games Route

// Route::get('top-games', [GameController::class,'getTopGames']);
Route::post('create-games',[GameController::class,'createGames']);
Route::post('update-game',[GameController::class,'updateGame']);
Route::Delete('delete-game/{id}',[GameController::class,'deleteGame']);

// Route::get('getPc',[PcController::class,'index']);

// Normal Pc Route

Route::post('create-pc',[PcController::class,'store']);
Route::post('update-pc',[PcController::class,'update']);
Route::Delete('delete-pc/{id}',[PcController::class,'delete']);

//Legacy PC Route

Route::post('create-legacy-pc',[PcController::class,'legacyStore']);
Route::post('update-legacy-pc',[PcController::class,'update']);
Route::Delete('delete-legacy-pc/{id}',[PcController::class,'delete']);


//Workstation PC Route

Route::post('create-workstation-pc',[PcController::class,'workstationStore']);
Route::post('update-workstation-pc',[PcController::class,'update']);
Route::Delete('delete-workstation-pc/{id}',[PcController::class,'delete']);
