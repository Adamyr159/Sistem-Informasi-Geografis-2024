<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetaController::class, 'index']);
