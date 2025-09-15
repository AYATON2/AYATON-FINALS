<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;

// Routes for Contact
Route::get('/contacts', [ContactController::class, 'index']);  // Show all contacts
Route::post('/contacts', [ContactController::class, 'store']);  // Store a new contact


// Routes for Person (Blade Views and Form Submissions)
Route::get('/', [PersonController::class, 'index'])->name('person.index'); // Show the form and list
Route::post('/person', [PersonController::class, 'store'])->name('person.store'); // Store a new person
Route::put('/person/{id}', [PersonController::class, 'update'])->name('person.update'); // Update a person
Route::delete('/person/{id}', [PersonController::class, 'destroy'])->name('person.delete'); // Delete a person

// routes/web.php

// routes/web.php

use App\Http\Controllers\PeopleController;

// Web routes for People management

Route::get('/people', [PeopleController::class, 'index'])->name('people.index'); // Show people list
Route::post('/people', [PeopleController::class, 'store'])->name('people.store'); // Store a new person
Route::put('/people/{id}', [PeopleController::class, 'update'])->name('people.update'); // Update a person
Route::delete('/people/{id}', [PeopleController::class, 'destroy'])->name('people.delete'); // Delete a person

