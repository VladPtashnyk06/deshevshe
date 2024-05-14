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
        });
    });
});

require __DIR__.'/auth.php';
