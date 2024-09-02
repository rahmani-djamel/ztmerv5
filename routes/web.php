<?php

use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\MarketController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard',[HomeController::class,'index'])->name('dashboard');

    Route::prefix('product')->as('product.')->middleware(['role:SuperAdmin|Vendor'])->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('role:Vendor'); 
    });
    
    Route::prefix('market')->as('market.')->middleware(['role:SuperAdmin|Vendor'])->group(function () {
        Route::get('/', [MarketController::class, 'index'])->name('index');
    });
    Route::prefix('city')->as('city.')->middleware(['role:SuperAdmin'])->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::get('/create', [CityController::class, 'create'])->name('create');
        Route::post('/create', [CityController::class, 'store'])->name('store');
        Route::get('/edit/{city}', [CityController::class, 'edit'])->name('edit');
        Route::patch('/update/{city}', [CityController::class, 'update'])->name('update');
        Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
    });

    
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
