<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetaController::class, 'index']);
Route::get('/choroplet', [PetaController::class, 'choroplet'])->name('choroplet');
Route::get('/geojson', [PetaController::class, 'getGeoJson']);
