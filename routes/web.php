<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Campus\CampusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Timonel\TimonelAuthController;
use App\Http\Controllers\Timonel\TimonelController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('pagina_web', function(){
    return view('index_pagina_web');
})->name('spagina_web');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//rutas del timonel
Route::prefix('timonel')->name('timonel.')->group(function () {

    //Login
    Route::get('/login', [TimonelAuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [TimonelAuthController::class, 'login'])
        ->name('login.post');
    Route::post('/logout', [TimonelAuthController::class, 'logout'])
        ->name('logout');

    //vistas protegidas
    Route::middleware('auth:timonel')->group(function () {
        Route::get('/', [TimonelController::class, 'index'])
            ->name('index');
        Route::get('/admin', [TimonelController::class, 'admin'])
            ->name('admin');
        Route::patch('/usuarios/{id}/rol', [TimonelController::class, 'cambiarRol'])
            ->name('cambiarRol');
    });

});

//rutas del campus
Route::middleware(['auth'])->group(function () {
    Route::get('/campus', [CampusController::class, 'index'])
        ->name('campus.index');
});

require __DIR__.'/auth.php';
