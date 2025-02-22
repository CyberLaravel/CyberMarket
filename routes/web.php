<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\Admin\SellerApplicationController as AdminSellerApplicationController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('products', controller: ProductController::class);
    Route::resource('orders', OrderController::class);


    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])
        ->name('product-images.destroy');

    Route::patch('/product-images/{productImage}/set-primary', [ProductImageController::class, 'setPrimary'])
        ->name('product-images.set-primary');

    // Seller Application Routes
    Route::get('/seller/apply', [SellerApplicationController::class, 'create'])->name('seller.apply');
    Route::post('/seller/apply', [SellerApplicationController::class, 'store']);
});

// Define a common middleware group
$commonMiddleware = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
];

// Admin routes
Route::middleware($commonMiddleware + ['admin'])->group(function () {


    // Add more admin routes here
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin',

    ])->group(function () {
        Route::get(
            '/admin/dashboard',
            [AdminController::class, 'dashboard']
        )->name('admin.dashboard');


        Route::get('/admin/seller-applications', [AdminSellerApplicationController::class, 'index'])
            ->name('admin.seller-applications.index');
        Route::get('/admin/seller-applications/{application}', [AdminSellerApplicationController::class, 'show'])
            ->name('admin.seller-applications.show');
        Route::post('/admin/seller-applications/{application}/approve', [AdminSellerApplicationController::class, 'approve'])
            ->name('admin.seller-applications.approve');
        Route::post('/admin/seller-applications/{application}/reject', [AdminSellerApplicationController::class, 'reject'])
            ->name('admin.seller-applications.reject');
    });
});

// Seller routes
Route::middleware($commonMiddleware + ['seller'])->group(function () {
    Route::get(
        '/seller/dashboard',
        [SellerController::class, 'dashboard']
    )->name('seller.dashboard');
    // Add more seller routes here
});
