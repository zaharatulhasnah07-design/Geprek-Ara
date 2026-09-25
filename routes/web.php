<?php

use Illuminate\Support\Facades\Route;

// 1. Tampilan Utama (localhost:8000) -> Menampilkan Halaman Login Kasir
Route::get('/', function () {
    return view('auth.login-kasir');
});

// 2. Route Halaman Login
Route::get('/login', function () {
    return view('auth.login-kasir');
})->name('login');

// 3. Route Halaman Utama POS Kasir
Route::get('/pos', function () {
    return view('pos.index');
})->name('pos.index');

// 4. Route Halaman Dashboard & Grafik
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');