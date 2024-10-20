<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\LogoController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\PixelController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\TopHeaderController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\backend\MemberShipController;
use App\Http\Controllers\backend\SocialLinkController;
use App\Http\Controllers\backend\AdminDashboardController;

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



//route for admin panel

Route::middleware('admin.redirect')->group(function (){
     //admin login
     Route::get('admin/login', [LoginController::class, 'loginPage'])->name('admin.login');
     Route::post('admin/login', [LoginController::class, 'loged_in'])->name('admin.loged_in');
});


Route::middleware('admin')->group(function (){
    Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

    //dashboard route
    Route::name('admin.dashboard.')->prefix('admin/dashboard')->group(function(){
        Route::get('/index',[AdminDashboardController::class, 'dashboard'])->name('index');

    });
    // category route
    Route::name('admin.category.')->prefix('admin/category')->group(function () {
        Route::get('/list',[AdminDashboardController::class, 'categoryList'])->name('list');
        Route::get('/page',[AdminDashboardController::class, 'categoryPage'])->name('page');
        Route::post('/store',[AdminDashboardController::class, 'categoryStore'])->name('store');
        Route::get('/update/{id}',[AdminDashboardController::class, 'categoryupdatePage'])->name('update.page');
        Route::post('/update',[AdminDashboardController::class, 'categoryUpdate'])->name('update');
        Route::get('/delete/{id}',[AdminDashboardController::class, 'categoryDelete'])->name('delete');
        Route::get('/status/update/{id}',[AdminDashboardController::class, 'categoryStatusUpdate'])->name('status.update');
    });


    // sub category route 
    Route::name('admin.sub.cat.')->prefix('admin/sub/cat')->group(function () {
        Route::get('/list',[AdminDashboardController::class, 'subcategoryList'])->name('list');
        Route::get('/create',[AdminDashboardController::class, 'subCatCreate'])->name('create');
        Route::post('/store',[AdminDashboardController::class, 'subcategoryStore'])->name('store');
        Route::get('/update/{id}',[AdminDashboardController::class, 'subcategoryupdatePage'])->name('update.page');
        Route::post('/update',[AdminDashboardController::class, 'subcategoryUpdate'])->name('update');
        Route::get('/delete/{id}',[AdminDashboardController::class, 'subcategoryDelete'])->name('delete');
        Route::get('/status/update/{id}',[AdminDashboardController::class, 'subcategoryStatusUpdate'])->name('status.update');
        
    });

    // product route 
    Route::name('admin.product.')->prefix('admin/product')->group(function () {
        Route::get('/list',[ProductController::class, 'productList'])->name('list');
        Route::get('/search',[ProductController::class, 'productSearchList'])->name('search');
        Route::get('/create',[ProductController::class, 'productCreate'])->name('create');
        Route::post('/store',[ProductController::class, 'productStore'])->name('store');
        Route::get('/update/{id}/{type}',[ProductController::class, 'productupdatePage'])->name('update.page');
        Route::post('/update',[ProductController::class, 'productUpdate'])->name('update');
        Route::get('/delete/{id}',[ProductController::class, 'productDelete'])->name('delete');
        Route::get('/status/update/{id}',[ProductController::class, 'productStatusUpdate'])->name('status.update');
        
    });

    // slider route
    Route::name('admin.slider.')->prefix('admin/slider')->group(function () {
        Route::get('/list',[SliderController::class, 'sliderList'])->name('list');
        Route::get('/page',[SliderController::class, 'sliderPage'])->name('page');
        Route::post('/store',[SliderController::class, 'sliderStore'])->name('store');
        Route::get('/update/{id}',[SliderController::class, 'sliderupdatePage'])->name('update.page');
        Route::post('/update',[SliderController::class, 'sliderUpdate'])->name('update');
        Route::get('/delete/{id}',[SliderController::class, 'sliderDelete'])->name('delete');
        Route::get('/status/update/{id}',[SliderController::class, 'sliderStatusUpdate'])->name('status.update');
    });

    // User route
    Route::name('admin.user.')->prefix('admin/user')->group(function () {
        Route::get('/list',[UserController::class, 'userList'])->name('list');
        Route::get('/page',[UserController::class, 'uesrPage'])->name('page');
        Route::post('/store',[UserController::class, 'userStore'])->name('store');
        Route::get('/update/{id}',[UserController::class, 'userupdatePage'])->name('update.page');
        Route::post('/update',[UserController::class, 'userUpdate'])->name('update');
        Route::get('/delete/{id}',[UserController::class, 'userDelete'])->name('delete');
        Route::get('/status/update/{id}',[UserController::class, 'userStatusUpdate'])->name('status.update');
    });

    //order route
    Route::name('admin.order.')->prefix('admin/order')->group(function () {
        Route::get('/list',[OrderController::class, 'orderList'])->name('list');
        Route::get('/search',[OrderController::class, 'orderSearchList'])->name('search');
        Route::get('/page',[OrderController::class, 'uesrPage'])->name('page');
        Route::post('/store',[OrderController::class, 'userStore'])->name('store');
        Route::get('/update/{id}',[OrderController::class, 'userupdatePage'])->name('update.page');
        Route::post('/update',[OrderController::class, 'userUpdate'])->name('update');
        Route::get('/delete/{id}',[OrderController::class, 'userDelete'])->name('delete');
        Route::get('/status/update',[OrderController::class, 'orderStatusUpdate'])->name('status.update');
    });

    // top header route
    Route::name('admin.top-header.')->prefix('admin/top-header')->group(function () {
        Route::get('/list',[TopHeaderController::class, 'List'])->name('list');
        Route::get('/page',[TopHeaderController::class, 'create'])->name('create');
        Route::post('/store',[TopHeaderController::class, 'store'])->name('store');
        Route::get('/update/{id}',[TopHeaderController::class, 'update_page'])->name('update.page');
        Route::post('/update',[TopHeaderController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[TopHeaderController::class, 'delete'])->name('delete');
        Route::get('/status/update/{id}',[TopHeaderController::class, 'status'])->name('status.update');
    });

    // logo route
    Route::name('admin.logo.')->prefix('admin/logo')->group(function () {
        Route::get('/list',[LogoController::class, 'List'])->name('list');
        Route::get('/page',[LogoController::class, 'create'])->name('create');
        Route::post('/store',[LogoController::class, 'store'])->name('store');
        Route::get('/update/{id}',[LogoController::class, 'update_page'])->name('update.page');
        Route::post('/update',[LogoController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[LogoController::class, 'delete'])->name('delete');
        Route::get('/status/update/{id}',[LogoController::class, 'status'])->name('status.update');
    });
    // social media route
    Route::name('admin.social_link.')->prefix('admin/social_link')->group(function () {
        Route::get('/list',[SocialLinkController::class, 'List'])->name('list');
        Route::get('/page',[SocialLinkController::class, 'create'])->name('create');
        Route::post('/store',[SocialLinkController::class, 'store'])->name('store');
        Route::get('/update/{id}',[SocialLinkController::class, 'update_page'])->name('update.page');
        Route::post('/update',[SocialLinkController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[SocialLinkController::class, 'delete'])->name('delete');
        Route::get('/status/update/{id}',[SocialLinkController::class, 'status'])->name('status.update');
    });

    // facebook meta pixel
    Route::name('admin.meta-pixel.')->prefix('admin/meta-pixel')->group(function () {
        Route::get('/list',[PixelController::class, 'List'])->name('list');
        Route::get('/page',[PixelController::class, 'create'])->name('create');
        Route::post('/store',[PixelController::class, 'store'])->name('store');
        Route::get('/update/{id}',[PixelController::class, 'update_page'])->name('update.page');
        Route::post('/update',[PixelController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[PixelController::class, 'delete'])->name('delete');
        Route::get('/status/update/{id}',[PixelController::class, 'status'])->name('status.update');
    });

    // member route
    Route::name('admin.member.')->prefix('admin/member')->group(function () {
        Route::get('/list',[MemberShipController::class, 'List'])->name('list');
        Route::get('/search',[MemberShipController::class, 'searchList'])->name('search');

    });

    //profile route

    Route::name('admin.profile.')->prefix('admin/profile')->group(function () {
        Route::get('/update/page',[ProfileController::class, 'update_profile_page'])->name('update.page');
        Route::post('/update',[ProfileController::class, 'update_profile'])->name('update');
        Route::get('/change/password/page',[ProfileController::class, 'change_password_page'])->name('change.password.page');
        Route::post('/change/password',[ProfileController::class, 'change_password'])->name('change.password');
        Route::get('/page',[ProfileController::class, 'page'])->name('page');

    });
    //stead fast
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/order/status', [OrderController::class, 'OrderStatus'])->name('order.status');
});







