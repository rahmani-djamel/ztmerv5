<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\MarketController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShippingAdress;
use App\Http\Controllers\Dashboard\StateController;
use App\Http\Controllers\Dashboard\UnitController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/',[IndexController::class,'index'])->name('front.index');
Route::get('/product/{type?}',[FrontendProductController::class,'index'])->name('front.product');



Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard',[HomeController::class,'index'])->name('dashboard');




    Route::prefix('setting')->as('setting.')->group(function(){
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/update/{tab}', [SettingController::class, 'update'])->name('update');
    });

    Route::prefix('category')->as('category.')->middleware(['role:SuperAdmin'])->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/create', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });



    Route::prefix('product')->as('product.')->middleware(['role:SuperAdmin|Vendor'])->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('role:Vendor');
        Route::post('/create', [ProductController::class, 'store'])->name('store')->middleware('role:Vendor'); 
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit')->middleware('role:Vendor');
        Route::post('/update/{product}', [ProductController::class, 'update'])->name('update')->middleware('role:Vendor');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy')->middleware('role:Vendor');
    });

    Route::prefix('user')->as('user.')->middleware(['role:SuperAdmin'])->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

    });

    
    Route::prefix('market')->as('market.')->middleware(['role:SuperAdmin|Vendor'])->group(function () {
        Route::get('/', [MarketController::class, 'index'])->name('index');
        Route::get('/create', [MarketController::class, 'create'])->name('create')->middleware('role:Vendor');
        Route::post('/create', [MarketController::class, 'store'])->name('store')->middleware('role:Vendor');
        Route::get('/edit/{market}', [MarketController::class, 'edit'])->name('edit')->middleware('role:Vendor');
        Route::patch('/update/{market}', [MarketController::class, 'update'])->name('update')->middleware('role:Vendor');
        Route::delete('/{market}', [MarketController::class, 'destroy'])->name('destroy')->middleware('role:Vendor');
    });

    Route::prefix('unit')->as('unit.')->middleware(['role:SuperAdmin'])->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/create', [UnitController::class, 'store'])->name('store');
        Route::get('/edit/{unit}', [UnitController::class, 'edit'])->name('edit');
        Route::patch('/update/{unit}', [UnitController::class, 'update'])->name('update');
        Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('state')->as('state.')->middleware(['role:Vendor'])->group(function () {
        Route::get('/{stateId}/cities', [StateController::class, 'getCities'])->name('index');
    });

    Route::prefix('package')->as('package.')->middleware(['role:SuperAdmin'])->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::get('/create', [PackageController::class, 'create'])->name('create');
        Route::post('/create', [PackageController::class, 'store'])->name('store');
        Route::get('/edit/{package}', [PackageController::class, 'edit'])->name('edit');
        Route::patch('/update/{package}', [PackageController::class, 'update'])->name('update');
        Route::delete('/{package}', [PackageController::class, 'destroy'])->name('destroy');
    });



    

    Route::prefix('city')->as('city.')->middleware(['role:SuperAdmin'])->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::get('/create', [CityController::class, 'create'])->name('create');
        Route::post('/create', [CityController::class, 'store'])->name('store');
        Route::get('/edit/{city}', [CityController::class, 'edit'])->name('edit');
        Route::patch('/update/{city}', [CityController::class, 'update'])->name('update');
        Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('addresses')->as('addresses.')->middleware(['role:SuperAdmin|User'])->group(function () {
        Route::get('/', [ShippingAdress::class, 'index'])->name('index');
        Route::get('/create', [ShippingAdress::class, 'create'])->name('create')->middleware('role:User');
        Route::post('/create', [ShippingAdress::class, 'store'])->name('store')->middleware('role:User');
        Route::get('/edit/{address}', [ShippingAdress::class, 'edit'])->name('edit');
        Route::patch('/update/{address}', [ShippingAdress::class, 'update'])->name('update');
        Route::delete('/{address}', [ShippingAdress::class, 'destroy'])->name('destroy');

    });


    
});







require __DIR__.'/auth.php';
