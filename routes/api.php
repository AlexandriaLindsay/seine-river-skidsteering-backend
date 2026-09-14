<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SiteController::class, 'settings']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1');