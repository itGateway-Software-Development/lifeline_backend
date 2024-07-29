<?php

use App\Http\Controllers\Admin\AcademicActivityController;
use App\Http\Controllers\Admin\PromotionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CSRController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewEventController;
use App\Http\Controllers\Admin\PrincipleController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PhotoGalleryController;

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
Route::get('/', function () {return redirect()->route('admin.home');});

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');

    //permission
    Route::get('/permission-datatable', [PermissionController::class, 'dataTable']);
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::get('/roles-datatable', [RolesController::class, 'dataTable']);
    Route::resource('roles', RolesController::class);

    //users
    Route::get('/users-datatable', [UserController::class, 'dataTable']);
    Route::resource('users', UserController::class);

    //principle
    Route::get('/principle-datatable', [PrincipleController::class, 'dataTable']);
    Route::resource('principles', PrincipleController::class);

    //group
    Route::get('/group-datatable', [GroupController::class, 'dataTable']);
    Route::resource('groups', GroupController::class);

    //category
    Route::get('/category-datatable', [CategoryController::class, 'dataTable']);
    Route::resource('categories', CategoryController::class);

    //ingredient
    Route::get('/ingredient-datatable', [IngredientController::class, 'dataTable']);
    Route::resource('ingredients', IngredientController::class);

    //media photo upload
    Route::post('/media/storeMedia', [MediaController::class, 'storeMedia'])->name('media.storeMedia');
    Route::post('/media/deleteMedia', [MediaController::class, 'deleteMedia'])->name('media.deleteMedia');

    //products
    Route::get('/product-datatable', [ProductController::class, 'dataTable']);
    Route::post('/products/storeMedia', [ProductController::class, 'storeMedia'])->name('products.storeMedia');
    Route::post('/products/deleteMedia', [ProductController::class, 'deleteMedia'])->name('products.deleteMedia');
    Route::get('/product-get-group', [ProductController::class, 'getGroup'])->name('product.get-group');
    Route::resource('products', ProductController::class);

    Route::group(['prefix' => 'activity'], function() {
        //photo gallery
        Route::get('/photo-gallery-list', [PhotoGalleryController::class, 'photoGalleryLists']);
        Route::post('/photo-gallery/storeMedia', [PhotoGalleryController::class, 'storeMedia'])->name('photo-gallery.storeMedia');
        Route::post('/photo-gallery/deleteMedia', [PhotoGalleryController::class, 'deleteMedia'])->name('photo-gallery.deleteMedia');
        Route::resource('photo-gallery', PhotoGalleryController::class);

        // csr activities
        Route::get('/csr-activities-list', [CSRController::class, 'csrLists']);
        Route::post('/csr-activities/storeMedia', [CSRController::class, 'storeMedia'])->name('csr-activities.storeMedia');
        Route::post('/csr-activities/deleteMedia', [CSRController::class, 'deleteMedia'])->name('csr-activities.deleteMedia');
        Route::resource('csr-activities', CSRController::class);

        // new & events
        Route::get('/new-events-list', [NewEventController::class, 'newsList']);
        Route::resource('new-events', NewEventController::class);

        // academic activities
        Route::get('/academic-activities-list', [AcademicActivityController::class, 'academicActivityList']);
        Route::resource('academic-activities', AcademicActivityController::class);
    });

    Route::group(['prefix' => 'company-setting'], function() {
        //service
        Route::get('/services-list', [ServiceController::class, 'serviceLists']);
        Route::get('/change-service-status', [ServiceController::class, 'changeStatus']);
        Route::resource('services', ServiceController::class);

        //promotion
        Route::get('/promotions-list', [PromotionController::class, 'promotionLists']);
        Route::get('/change-promotions-status', [PromotionController::class, 'changeStatus']);
        Route::resource('promotions', PromotionController::class);
    });
});

require __DIR__ . '/auth.php';
