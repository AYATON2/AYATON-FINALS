<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PeopleController;

Route::get('/people', [PeopleController::class, 'index']); // Fetch all people
Route::post('/people', [PeopleController::class, 'store']); // Create a new person
Route::get('/people/{id}', [PeopleController::class, 'show']); // Fetch a specific person
Route::put('/people/{id}', [PeopleController::class, 'update']); // Update an existing person
Route::delete('/people/{id}', [PeopleController::class, 'destroy']); // Delete a perso
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\ContactController;

Route::post('/contacts', [ContactController::class, 'store']);

