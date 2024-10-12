<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\FrontendController;
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
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/cart/count', function () {
    $totalItems = session()->get('cart_count', 0);
   
    return response()->json(['count' => $totalItems]);
})->name('cart.count');

//frontend route
Route::get('/customer-login', [FrontendController::class, 'login_page'])->name('frontend.login');
Route::post('/customer-logedin', [FrontendController::class, 'customer_login'])->name('frontend.customer.login');
Route::get('customer/logout', [FrontendController::class, 'customer_logout'])->name('frontend.customer.logout');
Route::get('/customer-register', [FrontendController::class, 'register_page'])->name('frontend.register');
Route::post('/customer-registration', [FrontendController::class, 'customer_registration'])->name('frontend.customer.register');

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/categoty-page/{id}', [FrontendController::class, 'category_page'])->name('frontend.category.page');
Route::get('/single-product/{id}', [FrontendController::class, 'single_product'])->name('frontend.single.product.page');
Route::get('/shop-checkout', [FrontendController::class, 'shop_checkout'])->name('shop.checkout');
Route::post('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('/shopping/card', [FrontendController::class, 'shopping_card'])->name('shopping.card');
Route::post('/cart/update/{id}', [FrontendController::class, 'update'])->name('cart.update');
Route::post('/cart/add', [FrontendController::class, 'cart_add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [FrontendController::class, 'remove'])->name('cart.remove');
Route::get('/search', [FrontendController::class, 'search'])->name('search.results');
Route::post('/single-product/quick_view', [FrontendController::class, 'single_product_quick_view'])->name('frontend.single.product.quick_view');
Route::get('/shop/page', [FrontendController::class, 'shop_page'])->name('shop.page');
//customer profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('user.profile');
Route::get('/profile/update/page', [ProfileController::class, 'profile_update_page'])->name('user.profile.update.page');
Route::post('/profile/update', [ProfileController::class, 'profile_update'])->name('user.profile.update');
Route::get('/address/update/page', [ProfileController::class, 'address_update_page'])->name('user.address.update.page');
Route::post('/address/update', [ProfileController::class, 'address_update'])->name('user.address.update');
Route::get('/invoice/{id}', [ProfileController::class, 'invoice'])->name('product.invoice');

//get dependency data route
Route::post('get/district',[ProfileController::class, 'get_district'])->name('get.district');
Route::post('get/upazila',[ProfileController::class, 'get_upazila'])->name('get.upazila');

// Route to update cart session
Route::get('/cart/count-div', [FrontendController::class, 'getCountDiv'])->name('cart.count.div');
Route::post('/clear-cart-session', [FrontendController::class, 'clearCartSession']);











