<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/photo', function () {
    return view('photo');
})->name('photo');

Route::get('/spesial-photo', function () {
    return view('spesial-photo');
})->name('spesial');

Route::get('/login', function () {
    abort(404);
})->name('login');

Route::get('/register', function () {
    abort(404);
})->name('register');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

Route::fallback(function () {
    abort(404);
});

require __DIR__.'/auth.php';
