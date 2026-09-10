<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Routes

// Endpoint untuk mendapatkan profil user jika menggunakan bearer token (Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
