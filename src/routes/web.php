<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{id}/detail', [ShopController::class, 'book'])->name('shops.detail');
Route::get('/review', [ReviewController::class, 'create'])->name('review');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/shops/{shop_id}/reviews', [ReviewController::class, 'index'])->name('shops.reviews');

