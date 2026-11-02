<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PasswordController::class, 'index'])->name('home');
Route::post('/generate', [PasswordController::class, 'generate'])->name('generate');
