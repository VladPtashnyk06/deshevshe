<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['prefix' => 'admin'], function () {
        Route::middleware('auth.admin')->group(function () {
            Route::group(['prefix' => 'color'], function () {
                Route::controller(\App\Http\Controllers\ColorController::class)->group(function () {
                    Route::get('/', 'index')->name('color.index');
                    Route::get('/create', 'create')->name('color.create');
                    Route::post('/store', 'store')->name('color.store');
                    Route::get('/edit/{color}', 'edit')->name('color.edit');
                    Route::post('/update/{color}', 'update')->name('color.update');
                    Route::delete('/delete/{color}', 'destroy')->name('color.destroy');
                });
            });
            Route::group(['prefix' => 'package'], function () {
                Route::controller(\App\Http\Controllers\PackageController::class)->group(function () {
                    Route::get('/', 'index')->name('package.index');
                    Route::get('/create', 'create')->name('package.create');
                    Route::post('/store', 'store')->name('package.store');
                    Route::get('/edit/{package}', 'edit')->name('package.edit');
                    Route::post('/update/{package}', 'update')->name('package.update');
                    Route::delete('/delete/{package}', 'destroy')->name('package.destroy');
                });
            });
            Route::group(['prefix' => 'material'], function () {
                Route::controller(\App\Http\Controllers\MaterialController::class)->group(function () {
                    Route::get('/', 'index')->name('material.index');
                    Route::get('/create', 'create')->name('material.create');
                    Route::post('/store', 'store')->name('material.store');
                    Route::get('/edit/{material}', 'edit')->name('material.edit');
                    Route::post('/update/{material}', 'update')->name('material.update');
                    Route::delete('/delete/{material}', 'destroy')->name('material.destroy');
                });
            });
            Route::group(['prefix' => 'characteristic'], function () {
                Route::controller(\App\Http\Controllers\CharacteristicController::class)->group(function () {
                    Route::get('/', 'index')->name('characteristic.index');
                    Route::get('/create', 'create')->name('characteristic.create');
                    Route::post('/store', 'store')->name('characteristic.store');
                    Route::get('/edit/{characteristic}', 'edit')->name('characteristic.edit');
                    Route::post('/update/{characteristic}', 'update')->name('characteristic.update');
                    Route::delete('/delete/{characteristic}', 'destroy')->name('characteristic.destroy');
                });
            });
            Route::group(['prefix' => 'size'], function () {
                Route::controller(\App\Http\Controllers\SizeController::class)->group(function () {
                    Route::get('/', 'index')->name('size.index');
                    Route::get('/create', 'create')->name('size.create');
                    Route::post('/store', 'store')->name('size.store');
                    Route::get('/edit/{size}', 'edit')->name('size.edit');
                    Route::post('/update/{size}', 'update')->name('size.update');
                    Route::delete('/delete/{size}', 'destroy')->name('size.destroy');
                });
            });
            Route::group(['prefix' => 'product_status'], function () {
                Route::controller(\App\Http\Controllers\StatusController::class)->group(function () {
                    Route::get('/', 'index')->name('status.index');
                    Route::get('/create', 'create')->name('status.create');
                    Route::post('/store', 'store')->name('status.store');
                    Route::get('/edit/{status}', 'edit')->name('status.edit');
                    Route::post('/update/{status}', 'update')->name('status.update');
                    Route::delete('/delete/{status}', 'destroy')->name('status.destroy');
                });
            });
            Route::group(['prefix' => 'producer'], function () {
                Route::controller(\App\Http\Controllers\ProducerController::class)->group(function () {
                    Route::get('/', 'index')->name('producer.index');
                    Route::get('/create', 'create')->name('producer.create');
                    Route::post('/store', 'store')->name('producer.store');
                    Route::get('/edit/{producer}', 'edit')->name('producer.edit');
                    Route::post('/update/{producer}', 'update')->name('producer.update');
                    Route::delete('/delete/{producer}', 'destroy')->name('producer.destroy');
                });
            });
            Route::group(['prefix' => 'category'], function () {
                Route::controller(\App\Http\Controllers\CategoryController::class)->group(function () {
                    Route::get('/', 'index')->name('category.index');
                    Route::get('/create', 'create')->name('category.create');
                    Route::post('/store', 'store')->name('category.store');
                    Route::get('/edit/{category}', 'edit')->name('category.edit');
                    Route::post('/update/{category}', 'update')->name('category.update');
                    Route::delete('/delete/{category}', 'destroy')->name('category.destroy');
                });
            });
        });
    });
});

require __DIR__.'/auth.php';
