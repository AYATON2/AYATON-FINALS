<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;

Route::get('/people', [PeopleController::class, 'getAll']); 
Route::post('/people', [PeopleController::class, 'store']);
Route::get('/people/{id}', [PeopleController::class, 'show']);
Route::put('/people/{id}', [PeopleController::class, 'update']); // ✅ ADDED THIS LINE
Route::put('/people/{id}/archive', [PeopleController::class, 'archive']);
Route::get('/people-archived', [PeopleController::class, 'archivedPeople']);
Route::delete('/people/{id}', [PeopleController::class, 'destroy']);
Route::delete('/people/{id}/force', [PeopleController::class, 'forceDelete']);
Route::put('/people/{id}/restore', [PeopleController::class, 'restoreFromArchive']);

Route::post('/contacts', [ContactController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
