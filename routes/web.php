<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix'=>'users'], function(){
        Route::get('/',                             [UsersController::class, 'index'])->name('users.index');
        Route::get('/create',                       [UsersController::class, 'create'])->name('users.create');
        Route::post('/create',                      [UsersController::class, 'store'])->name('users.store');
        Route::get('/{user}',                       [UsersController::class, 'show'])->name('users.show');
        Route::put('/{user}',                       [UsersController::class, 'update'])->name('users.update');
        Route::delete('/{user}',                    [UsersController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';
