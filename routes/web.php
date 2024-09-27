<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();
use App\Http\Controllers\UserController;
Route::middleware(['auth'])->group(function () {
    // Admin routes for managing users
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->middleware('admin'); // Only admin can access these routes

    // Allow both admin and user to view, edit, and update their own profiles
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show')
        ->middleware('adminOrUser');

    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')
        ->middleware('adminOrUser');

    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')
        ->middleware('adminOrUser');
});









Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
