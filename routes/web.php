<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetaController;

Route::get('/', function (){
    return view('index');
});
Route::get('/geomap', [PetaController::class, 'index'])->name('geomap');
Route::get('/choroplet', [PetaController::class, 'choroplet'])->name('choroplet');
Route::get('/geojson', [PetaController::class, 'getGeoJson']);
