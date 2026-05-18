<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Campus\CampusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Timonel\TimonelAuthController;
use App\Http\Controllers\Timonel\TimonelController;
use App\Http\Controllers\Timonel\MateriaController;
use App\Http\Controllers\Timonel\InscripcionController;
use App\Http\Controllers\Timonel\FacturaController;


Route::get('/', function () {
    return view('index_pagina_web');
});
Route::get('pagina_web', function(){
    return view('index_pagina_web');
})->name('pagina_web');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
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

    // ── MATERIAS ──
    Route::get('/materias', [MateriaController::class, 'index'])
    ->name('materias.index');
    Route::post('/materias', [MateriaController::class, 'store'])
    ->name('materias.store');
    Route::patch('/materias/{id}', [MateriaController::class, 'update'])
    ->name('materias.update');
    Route::delete('/materias/{id}', [MateriaController::class, 'destroy'])
    ->name('materias.destroy');

    // ── INSCRIPCIONES ──
    Route::get('/inscripcion', [InscripcionController::class, 'index'])
    ->name('inscripcion.index');
    Route::post('/inscripcion', [InscripcionController::class, 'store'])
    ->name('inscripcion.store');
    Route::delete('/inscripcion/{id}', [InscripcionController::class, 'destroy'])
    ->name('inscripcion.destroy');

    // ── FACTURAS ──
    Route::post('/factura', [FacturaController::class, 'store'])
    ->name('factura.store');
    Route::get('/factura/{id}', [FacturaController::class, 'show'])
    ->name('factura.show');

    // ── PROFESOR ──
    Route::get('/profesor', [TimonelController::class, 'profesorIndex'])
    ->name('profesor.index');
    Route::get('/profesor/materia/{id}', [TimonelController::class, 'profesorEstudiantes'])
    ->name('profesor.estudiantes');
});

});

//rutas del campus
Route::middleware(['auth'])->group(function () {
    Route::get('/campus', [CampusController::class, 'index'])
        ->name('campus.index');
});

require __DIR__.'/auth.php';
