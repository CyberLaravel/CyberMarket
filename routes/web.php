<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/login2', function () {
    return Inertia::render('Auth/Login2');
})->name('login2');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');




    Route::resource('products', controller: ProductController::class);
    Route::resource('orders', OrderController::class);
});

// Define a common middleware group
$commonMiddleware = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
];

// Admin routes
Route::middleware($commonMiddleware + ['admin'])->group(function () {
    Route::get(
        '/admin/dashboard',
        [AdminController::class, 'dashboard']
    )->name('admin.dashboard');

    // Add more admin routes here
});

// Seller routes
Route::middleware($commonMiddleware + ['seller'])->group(function () {
    Route::get(
        '/seller/dashboard',
        [SellerController::class, 'dashboard']
    )->name('seller.dashboard');
    // Add more seller routes here
});
