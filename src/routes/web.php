<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReviewsController;


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
Route::middleware(['auth'])->group(function () {
    Route::get('/shops/{id}/detail', [ShopController::class, 'book'])->name('shops.detail');
    Route::get('/review', [ReviewController::class, 'create'])->name('review');
    Route::post('/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::get('/shops/{shop_id}/reviews', [ReviewController::class, 'index'])->name('shops.reviews');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin')
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/import', [AdminController::class, 'importCsv'])->name('import');

    Route::get('/reviews', [AdminReviewsController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{shop}/delete', [AdminReviewsController::class, 'delete'])->name('reviews.delete');
    Route::delete('/reviews/{review}', [AdminReviewsController::class, 'destroy'])->name('reviews.destroy');
});
