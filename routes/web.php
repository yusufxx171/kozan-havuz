<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/kurumsal', [PageController::class, 'about'])->name('about');

Route::get('/uygulamalarimiz', [ServiceController::class, 'index'])->name('services.index');
Route::get('/uygulamalarimiz/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/urunler/kategori/{category:slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/urunler/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/iletisim', [ContactController::class, 'show'])->name('contact');
Route::post('/iletisim', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/sayfa/{page:slug}', [PageController::class, 'show'])->name('pages.show');
