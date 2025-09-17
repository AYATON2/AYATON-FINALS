<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

// Routes for Contact
Route::get('/contacts', [ContactController::class, 'index']);  // Show all contacts
Route::post('/contacts', [ContactController::class, 'store']);  // Store a new contact


// routes/web.php

// routes/web.php

use App\Http\Controllers\PeopleController;

// Web routes for People management
Route::get('/people', [PeopleController::class, 'index']);


