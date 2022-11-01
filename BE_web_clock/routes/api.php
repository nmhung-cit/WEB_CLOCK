<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//admin
Route::post('/admin-register','ApiAdminController@register');
Route::post('/admin-login','ApiAdminController@login');
Route::get('/admin-information','ApiAdminController@adminInfor')->middleware(['auth:api_admin','scopes:admin']);
Route::resource('/add-product', 'Admin\ApiProductController')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/deletes', 'Admin\ApiProductController@deletes')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/update/{id}', 'Admin\ApiProductController@dataupload')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/update-details-product', 'Admin\ApiProductController@UpdateProductDetails')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/update-insurances', 'Admin\ApiProductController@UpdateInsurances')->middleware(['auth:api_admin','scopes:admin']);
Route::get('/get-images/{id}', 'Admin\ApiProductController@GetImages')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/add-images', 'Admin\ApiProductController@AddImages')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/delete-images', 'Admin\ApiProductController@DeleteImages')->middleware(['auth:api_admin','scopes:admin']);
Route::get('/admin-get-order', 'User\OderController@AdimGetOrder')->middleware(['auth:api_admin','scopes:admin']);
Route::get('/admin-get-orderdetails/{id}', 'User\OderController@AdminGetOrderDetails')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/admin-up-status/{id}/{status}', 'User\OderController@UpStatusOrder')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/get-feedback-reviews/{id}', 'User\OderController@GetFeedbackReviews')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/set-feedback-reviews/{id}', 'User\OderController@SetFeedbackReviews')->middleware(['auth:api_admin','scopes:admin']);
Route::get('/get-slide', 'ApiSlideController@GetImageSlide')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/add-image-slide', 'ApiSlideController@AddSlide')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/delete-image-slide', 'ApiSlideController@DeleteImageSlide')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/add-news', 'ApiNewsController@Addnews')->middleware(['auth:api_admin','scopes:admin']);
Route::get('/get-news', 'ApiNewsController@GetNews')->middleware(['auth:api_admin','scopes:admin']);
Route::post('/delete-news', 'ApiNewsController@DeleteNews')->middleware(['auth:api_admin','scopes:admin']);
//user
Route::post('/user-register','ApiUserController@register');
Route::post('/user-login','ApiUserController@login');
Route::get('/user-information','ApiUserController@userInfor')->middleware(['auth:api_user','scopes:user']);
Route::get('/product', 'User\ProductController@Product');
Route::get('/shearch-product/{name}', 'User\ProductController@ShearchProduct');
Route::get('/productold', 'User\ProductController@productOld');
Route::get('/productincrease', 'User\ProductController@productIncrease');
Route::get('/productdiscount', 'User\ProductController@productdiscount');

Route::get('/menproduct', 'User\ProductController@MenProduct');
Route::get('/menproductold', 'User\ProductController@MenproductOld');
Route::get('/menproductincrease', 'User\ProductController@MenproductIncrease');
Route::get('/menproductdiscount', 'User\ProductController@menproductdiscount');

Route::get('/womenproduct', 'User\ProductController@WomenProduct');
Route::get('/womenproductold', 'User\ProductController@WomenproductOld');
Route::get('/womenproductincrease', 'User\ProductController@WomenproductIncrease');
Route::get('/womenproductdiscount', 'User\ProductController@Womenproductdiscount');

Route::get('/Home-product-featured', 'User\ProductController@HomeProductFeatured');
Route::get('/Home-product-men', 'User\ProductController@HomeproductMen');
Route::get('/Home-product-women', 'User\ProductController@HomeproductWomen');
Route::get('/getnewproduct', 'User\ProductController@getnewproduct');
Route::get('/trademark', 'User\ProductController@trademark');
Route::get('/productdetails/{id}', 'User\ProductController@Productdetails');
Route::post('/cart', 'User\CartController@Cart')->middleware(['auth:api_user','scopes:user']);
Route::post('/getcart', 'User\CartController@GetCart')->middleware(['auth:api_user','scopes:user']);
Route::post('/getproductcart', 'User\CartController@GetProductCart')->middleware(['auth:api_user','scopes:user']);
Route::post('/deletecart', 'User\CartController@DeleteCart')->middleware(['auth:api_user','scopes:user']);
Route::post('/updatecart', 'User\CartController@UpdateCart')->middleware(['auth:api_user','scopes:user']);
Route::post('/updatepassword', 'ApiUserController@UpdatePassword')->middleware(['auth:api_user','scopes:user']);
Route::post('/updateuser', 'ApiUserController@UpdateUser')->middleware(['auth:api_user','scopes:user']);
Route::post('/shipment-details', 'ApiUserController@ShipmentDetails')->middleware(['auth:api_user','scopes:user']);
Route::post('/up-shipment-details', 'ApiUserController@UpShipmentDetails')->middleware(['auth:api_user','scopes:user']);
Route::get('/user-get-images/{id}', 'User\ProductController@GetImages');
Route::post('/order', 'User\OderController@Addder')->middleware(['auth:api_user','scopes:user']);
Route::post('/order-details', 'User\OderController@AddOrderDetail')->middleware(['auth:api_user','scopes:user']);
Route::get('/delete-user-cart/{id}', 'User\CartController@DeleteUserCart')->middleware(['auth:api_user','scopes:user']);
Route::get('/get-oder/{id}', 'User\OderController@GetOrder')->middleware(['auth:api_user','scopes:user']);
Route::get('/get-oder-dertails/{id}', 'User\OderController@GetOrderdetails')->middleware(['auth:api_user','scopes:user']);
Route::post('/cancel-order/{id}/{id_user}/{status}', 'User\OderController@CancelOrder')->middleware(['auth:api_user','scopes:user']);
Route::post('/product-reviews/{id}', 'User\OderController@GetProductReviews')->middleware(['auth:api_user','scopes:user']);
Route::post('/set-reviews', 'User\OderController@SetReviews')->middleware(['auth:api_user','scopes:user']);
Route::get('/get-reviews-product/{id}', 'User\ProductController@GetProductReview');
Route::get('/get-star/{id}', 'User\ProductController@GetStar');
Route::get('/user-get-slide', 'ApiSlideController@GetImageSlide');
Route::get('/user-get-news', 'ApiNewsController@GetNews');
Route::get('/get-new-news', 'ApiNewsController@getnewNews');
Route::get('/get-new-details/{id}', 'ApiNewsController@GetNewsDetail');
Route::get('/home-get-new-news', 'ApiNewsController@HomgetnewNews');



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
