<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes();

// Testing Spatie
Route::get('test_spatie', [AdminController::class, 'test_spatie']);
// Route::get('dashboard', [AdminController::class, 'dashboard']);
// Route::get('catalogs', [AdminController::class, 'catalogs']);
// Route::get('books', [AdminController::class, 'books']);
// Route::get('authors', [AdminController::class, 'authors']);
// Route::get('members', [AdminController::class, 'members']);
// Route::get('publishers', [AdminController::class, 'publishers']);
// Route::get('transactions', [AdminController::class, 'transactions']);

// Grouping data routes
Route::group([''], function() {
    Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);
    Route::resource('/books', App\Http\Controllers\BookController::class);
    Route::resource('/authors', App\Http\Controllers\AuthController::class);
    Route::resource('/members', App\Http\Controllers\MemberController::class);
    Route::resource('/publishers', App\Http\Controllers\PublisherController::class);
    Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
    Route::resource('/transactiondetails', App\Http\Controllers\TransactionDetailController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
});

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

// API routes
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/authors', [App\Http\Controllers\AuthController::class, 'api']);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
