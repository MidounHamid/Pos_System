<?php

use App\Http\Controllers\UniteController;
use App\Http\Controllers\ReglementController;
use App\Http\Controllers\ModeReglementController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\DetailBlController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::get('/', function () {
    return view('homme');
});

Route::get('/pos', function () {
    return view('pos');
})->name('pos');

// Resource routes for all controllers
Route::resource('unites', UniteController::class);
Route::resource('reglements', ReglementController::class);
Route::resource('mode_reglements', ModeReglementController::class);
Route::resource('marques', MarqueController::class);
Route::resource('familles', FamilleController::class);
Route::resource('details_bl', DetailBlController::class);
Route::resource('commandes', CommandeController::class);
Route::resource('clients', ClientController::class);
