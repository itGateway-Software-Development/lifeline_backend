<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\CsrController;
use App\Http\Controllers\Api\V1\Admin\GroupController;
use App\Http\Controllers\Api\V1\Admin\CareerController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\ServiceController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\LocationController;
use App\Http\Controllers\Api\V1\Admin\NewEventController;
use App\Http\Controllers\Api\V1\Admin\PositionController;
use App\Http\Controllers\Api\V1\Admin\PromotionController;
use App\Http\Controllers\Api\V1\Admin\PhotoGalleryController;
use App\Http\Controllers\Api\V1\Admin\AcademicActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    //Group
    Route::get('/groups', [GroupController::class, 'index']);
    Route::get('/groups/{group}', [GroupController::class, 'show']);

    //Category
    Route::get('/categories', [CategoryController::class, 'index']);

    //Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    //PhotoGalery
    Route::get('/photo-gallery', [PhotoGalleryController::class, 'index']);

    //csr
    Route::get('/csr-activities', [CsrController::class, 'index']);
    Route::get('/csr-activities/{id}', [CsrController::class, 'show']);
    Route::get('/get-csr-photos', [CsrController::class, 'getCsrPhotos']);

    //news-events
    Route::get('/news-events', [NewEventController::class, 'index']);
    Route::get('/news-events/{id}', [NewEventController::class, 'show']);

    //service
    Route::get('/services', [ServiceController::class, 'index']);

    //promotion
    Route::get('/promotions', [PromotionController::class, 'index']);

    //academic activity
    Route::get('/academic-activities', [AcademicActivityController::class, 'index']);

    //career
    Route::group(['prefix' => 'career'], function () {
        Route::get('/locations', [LocationController::class, 'index']);
        Route::get('/positions', [PositionController::class, 'index']);
        Route::get('/careers', [CareerController::class, 'index']);
        Route::post('/submit-cv', [CareerController::class, 'submitCv']);
    });


});
