<?php

use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Discount\CampaignController;
use App\Http\Controllers\Discount\DiscountController;
use App\Http\Controllers\Ecommerce\Cart\CartAdminController;
use App\Http\Controllers\Ecommerce\Cart\WishListController;
use App\Http\Controllers\Ecommerce\Client\AddressUserController;
use App\Http\Controllers\Ecommerce\Profile\ProfileController;
use App\Http\Controllers\Ecommerce\Profile\ReviewController;
use App\Http\Controllers\Ecommerce\Sale\SaleController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\People\StoreController;
use App\Http\Controllers\Product\Variant\ProductVariantController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategorieController;
use App\Http\Controllers\Product\ProductColorSizeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\Product\StateController;
use App\Http\Controllers\Product\SubcategorieController;
use App\Http\Controllers\Product\SupercategorieController;
use App\Http\Controllers\Sales\PosController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\People\CompanieController;
use App\Http\Controllers\Product\ProductSpecificationController;
use App\Http\Controllers\Ecommerce\Cart\CartEcommerceController;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::group(['prefix' => 'auth'], function ($router) {
    Route::get('/test', [JWTController::class, 'test']);

    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    //  Route::post('/loginAdmin', [JWTController::class, 'loginAdmin']);
    //   Route::post('/loginEcommerce', [JWTController::class, 'loginEcommerce']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);

    Route::post('/verified_auth', [JWTController::class, 'verified_auth'])->name('verified_auth');
    //
    Route::post('/verified_email', [JWTController::class, 'verified_email'])->name('verified_email');
    Route::post('/verified_code', [JWTController::class, 'verified_code'])->name('verified_code');
    Route::post('/new_password', [JWTController::class, 'new_password'])->name('new_password');

    Route::get('/companie/{code}', [CompanieController::class, 'show']);

    Route::group(['prefix' => 'admin'], function ($router) {
        Route::get('/test', [UserController::class, 'test']);
        Route::get('/all', [UserController::class, 'index']);
        Route::post('/register', [UserController::class, 'store']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);

        // Route::resource("coupons",CuponeController::class);
        // Route::resource("discounts",DiscountController::class);
        Route::resource("sliders",SliderController::class);
        Route::post("sliders/{id}",[SliderController::class,"update"]);


    });
});

Route::group(['prefix' => 'admin'], function ($router) {
    Route::resource("companie",CompanieController::class);

    Route::resource('campaigns', CampaignController::class);
    //        Route::get("discounts/config",[CampaignController::class,"config"]);

    /*
     * Route::group(["prefix" => "coupons"],function($router) {
     *     Route::get("/config_all",[CouponController::class,'config_all']);
     *     Route::get("/all",[CouponController::class,'index']);
     *     Route::get("/show/{id}",[CouponController::class,'show']);
     *     Route::post("/add",[CouponController::class,'store']);
     *     Route::post("/update/{id}",[CouponController::class,'update']);
     *     Route::delete("/delete/{id}",[CouponController::class,'destroy']);
     *
     * });
     */

    Route::put('discounts/change_state/{id}', [DiscountController::class, 'change_state']);
    Route::get('discounts/list', [DiscountController::class, 'list']);
    Route::get('discounts/info', [DiscountController::class, 'info']);
    Route::get('discounts/info_list', [DiscountController::class, 'info_list']);
    Route::get('discounts/products_autocomplete', [DiscountController::class, 'products_autocomplete']);
    Route::get('discounts/brands_autocomplete', [DiscountController::class, 'brands_autocomplete']);
    Route::get('discounts/categories_autocomplete', [DiscountController::class, 'categories_autocomplete']);
    Route::resource('discounts', DiscountController::class);

    // Route::group(["prefix" => "discounts"],function($router) {
    //     Route::get("/config",[DiscountController::class,'config']);
    //     Route::get("/all",[DiscountController::class,'index']);
    //     Route::get("/show/{id}",[DiscountController::class,'show']);
    //     Route::post("/add",[DiscountController::class,'store']);
    //     Route::put("/update/{id}",[DiscountController::class,'update']);
    //     Route::delete("/delete/{id}",[DiscountController::class,'destroy']);

    // });

    Route::put('coupons/change_state/{id}', [CouponController::class, 'change_state']);
    Route::get('coupons/list', [CouponController::class, 'list']);
    Route::get('coupons/info', [CouponController::class, 'info']);
    Route::get('coupons/info_list', [CouponController::class, 'info_list']);
    Route::get('coupons/products_autocomplete', [CouponController::class, 'products_autocomplete']);
    Route::get('coupons/brands_autocomplete', [CouponController::class, 'brands_autocomplete']);
    Route::get('coupons/categories_autocomplete', [CouponController::class, 'categories_autocomplete']);
    Route::resource('coupons', CouponController::class);
});
Route::group(['prefix' => 'products'], function ($router) {
    Route::group(['prefix' => 'supercategories'], function () {
        Route::get('/test', [SupercategorieController::class, 'test']);
        Route::get('/all', [SupercategorieController::class, 'index']);
        Route::get('/check_existence', [SupercategorieController::class, 'check_existence']);
        Route::post('/add', [SupercategorieController::class, 'store']);
        Route::get('/show/{id}', [SupercategorieController::class, 'show']);
        // post porque aunquesea update voy a pasar un archivo
        Route::post('/update/{id}', [SupercategorieController::class, 'update']);
        Route::delete('/delete/{id}', [SupercategorieController::class, 'destroy']);
        Route::put('/change_state/{id}', [SupercategorieController::class, 'change_state']);
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/test', [CategorieController::class, 'test']);
        Route::get('/all', [CategorieController::class, 'index']);
        Route::get('/check_existence', [CategorieController::class, 'check_existence']);
        Route::post('/add', [CategorieController::class, 'store']);
        Route::get('/show/{id}', [CategorieController::class, 'show']);
        // post porque aunquesea update voy a pasar un archivo
        Route::post('/update/{id}', [CategorieController::class, 'update']);
        Route::delete('/delete/{id}', [CategorieController::class, 'destroy']);
        Route::put('/change_state/{id}', [CategorieController::class, 'change_state']);
    });

    Route::group(['prefix' => 'subcategories'], function () {
        Route::get('/test', [SubcategorieController::class, 'test']);
        Route::get('/all', [SubcategorieController::class, 'index']);
        Route::get('/check_existence', [SubcategorieController::class, 'check_existence']);
        Route::post('/add', [SubcategorieController::class, 'store']);
        Route::get('/show/{id}', [SubcategorieController::class, 'show']);
        // post porque aunquesea update voy a pasar un archivo
        Route::post('/update/{id}', [SubcategorieController::class, 'update']);
        Route::delete('/delete/{id}', [SubcategorieController::class, 'destroy']);
        Route::put('/change_state/{id}', [SubcategorieController::class, 'change_state']);
    });

    Route::group(['prefix' => 'inventario'], function () {
        Route::post('/add', [ProductColorSizeController::class, 'store']);
        // Padre Totalizado
        Route::put('/update_size/{id}', [ProductColorSizeController::class, 'update_size']);
        Route::delete('/delete_size/{id}', [ProductColorSizeController::class, 'destroy_size']);
        // Hijos
        Route::put('/update/{id}', [ProductColorSizeController::class, 'update']);
        Route::delete('/delete/{id}', [ProductColorSizeController::class, 'destroy']);
    });

    Route::group(['prefix' => 'imgs'], function () {
        Route::get('/test', [ProductImageController::class, 'test']);
        Route::post('/add', [ProductImageController::class, 'store']);
        Route::delete('/delete/{id}', [ProductImageController::class, 'destroy']);
    });

    Route::get('/get_info', [ProductController::class, 'get_info']);
    Route::get('/all', [ProductController::class, 'index']);
    Route::get('/list', [ProductController::class, 'list']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
    Route::get('/show/{id}', [ProductController::class, 'show']);
    Route::post('/add', [ProductController::class, 'store']);
    Route::post('/import', [ProductController::class, 'import']);
    Route::put('/change_state/{id}', [ProductController::class, 'change_state']);

    Route::group(['prefix' => 'brands'], function ($router) {
        Route::get('/all', [BrandController::class, 'index']);
        Route::get('/show/{id}', [BrandController::class, 'show']);
        Route::post('/add', [BrandController::class, 'store']);
        Route::post('/update/{id}', [BrandController::class, 'update']);
        Route::delete('/delete/{id}', [BrandController::class, 'destroy']);

        Route::put('/change_state/{id}', [BrandController::class, 'change_state']);
        Route::get('/info', [BrandController::class, 'info']);
    });

    Route::group(['prefix' => 'variants'], function () {
        Route::get('/all', [ProductVariantController::class, 'index']);
        Route::post('/add', [ProductVariantController::class, 'store']);

        Route::delete('/delete/{id}', [ProductVariantController::class, 'destroy']);
    });

    Route::resource("specifications",ProductSpecificationController::class);


});

Route::group(['prefix' => 'info'], function () {
    Route::get('/states', [StateController::class, 'states']);
});

Route::group(['prefix' => 'load'], function () {
    Route::get('/catalogues', [CatalogueController::class, 'index']);
});

Route::group(['prefix' => 'header'], function () {
    Route::post('/load', [HeaderController::class, 'index']);
});

Route::group(['prefix' => 'peoples'], function () {
    Route::get('/store', [StoreController::class, 'index']);
    Route::group(['prefix' => 'store'], function () {
        Route::get('/list-short', [StoreController::class, 'index_short']);
    });
});

// Route::group(['prefix' => 'sliders'], function ($router) {
//     Route::get('/test', [SliderController::class, 'test']);
//     Route::get('/all', [SliderController::class, 'index']);
//     Route::post('/add', [SliderController::class, 'store']);
//     Route::post('/update/{id}', [SliderController::class, 'update']);
//     Route::delete('/delete/{id}', [SliderController::class, 'destroy']);
// });

Route::group(['prefix' => 'pos'], function ($router) {
    Route::get('/info', [PosController::class, 'info']);
    Route::get('/all', [PosController::class, 'index']);
    Route::get('/products', [PosController::class, 'products']);
    Route::get('/categories', [PosController::class, 'categories']);
    // Route::get("/show/{id}",[PosController::class,'show']);
    // Route::post("/add",[PosController::class,'store']);
    // Route::put("/update/{id}",[PosController::class,'update']);
    // Route::delete("/delete/{id}",[PosController::class,'destroy']);
    Route::group(['prefix' => 'cart'], function ($router) {
        Route::put('/all_update_currencie', [CartAdminController::class, 'all_update_currencie']);
        Route::delete('/all', [CartAdminController::class, 'delete_all']);
    });

    Route::resource('cart', CartAdminController::class);

    // Route::group(["prefix"=>"cart"],function(){
    //     Route::get("apply_coupon/{coupon}", [CartAdminController::class,'apply_coupon' ]);

    //    Route::resource("cart",CartAdminController::class);
    //     // Route:resource("cart",[CartAdminController::class,'index']);

    // });
});

Route::get('sale_mail/{id}', [SalesController::class, 'send_email']);
Route::post('sales/all', [SalesController::class, 'sale_all']);

Route::group(['prefix' => 'ecommerce'], function ($router) {

    Route::resource("companie",CompanieController::class);

   // Route::get('home/{id}', [HomeController::class, 'home']);
   Route::post('home', [HomeController::class, 'home']);
    Route::post('list-filter-products', [HomeController::class, 'list_filter_products']);
    Route::get('config_initial_filter', [HomeController::class, 'config_initial_filter']);
    Route::get('detail-product/{slug}', [HomeController::class, 'detail_product']);
    Route::get('show_product_details/{id}', [HomeController::class, 'show_product_details']);

    Route::get('product/{slug}', [HomeController::class, 'show_product_slug']);


    Route::resource('wishlist', WishListController::class);

    Route::group(['prefix' => 'checkout'], function () {
        Route::resource('address_user', AddressUserController::class);
        Route::post('sale', [SaleController::class, 'store']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('home', [ProfileController::class, 'index']);
        Route::post('profile_update', [ProfileController::class, 'profile_update']);
        Route::resource('reviews', ReviewController::class);
    });

    Route::group(['prefix' => 'header'], function () {
        Route::post('/load', [HeaderController::class, 'index']);
        Route::post('menus',[HomeController::class,'menus']);
    });

    Route::group([
        "middleware" => 'auth:api',
    ],function($router) {
      Route::group(['prefix' => 'cart'], function ($router) {
            Route::put('/all_update_currencie', [CartEcommerceController::class, 'all_update_currencie']);
            Route::delete('/all', [CartEcommerceController::class, 'delete_all']);
        });
        Route::resource('carts', CartEcommerceController::class);
    });

});
