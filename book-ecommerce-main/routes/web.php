<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Shopers\Account as SAccount;
use App\Http\Controllers\Users\Account as UAccount;
use App\Http\Controllers\Users\Checkout;

use App\Http\Controllers\Admin\Account as AAccount;
use App\Http\Controllers\Admin\Products as AProducts;
use App\Http\Controllers\Admin\Coupons;
use App\Http\Controllers\Admin\Orders as AOrders;
use App\Http\Controllers\Admin\Users;
use App\Http\Controllers\Admin\Shopers;
use App\Http\Controllers\Admin\Complaints;
use App\Http\Controllers\Admin\Products_Category;
use App\Http\Controllers\Admin\Edu_Category;
use App\Http\Controllers\Admin\Slider;

use App\Http\Controllers\Users\Cart;
use App\Http\Controllers\Products;
use App\Http\Controllers\Orders;
use App\Http\Controllers\Delivery;
use App\Http\Controllers\Send_Mail;
use App\Http\Controllers\Payment;

//----------------------------------------------//
//					Mail System
//----------------------------------------------//
Route::get('/send_mail', [Send_Mail::class, 'basic_email']);
Route::get('/payment',[]);
//----------------------------------------------//
//					Delivey System
//----------------------------------------------//
Route::get('/delivery',[Delivery::class,'view']);
Route::get('/delivery/change/{oid}/{status}',[Delivery::class,'change_status']);
//----------------------------------------------//
//					Users
//----------------------------------------------//
Route::get('/',[Products::class,'products']);
Route::get('/product/view/{id}',[Products::class,'view']);
Route::view('/login','users.login');
Route::post('/signin',[UAccount::class,'signin']);
Route::post('/signup',[UAccount::class,'signup']);
Route::get('/signout',[UAccount::class,'signout']);
Route::group(['middleware'=>['protected']],function(){

	Route::get('/account',[UAccount::class,'view_profile']);
	Route::post('/account/update/profile',[UAccount::class,'update_profile']);
	Route::post('/account/update/password',[UAccount::class,'update_password']);
	Route::post('/account/action/address',[UAccount::class,'action_address']);
	Route::post('/account/delete',[UAccount::class,'delete_account']);

	Route::get('/cart',[Cart::class,'items']);
	Route::get('/cart/item/add/{id}',[Cart::class,'add']);
	Route::get('/cart/item/remove/{id}',[Cart::class,'remove']);
	Route::get('/cart/item/increase/{id}',[Cart::class,'increase']);
	Route::get('/cart/item/decrease/{id}',[Cart::class,'decrease']);

	Route::post('/checkout_form', [Checkout::class,'checkout_form']);
	Route::post('/checkout_process', [Checkout::class,'checkout_process']);
	Route::post('/checkout_orders', [Checkout::class,'set_orders']);

	Route::get('/orders/', [Orders::class,'user_orders']);

});

//----------------------------------------------//
//					Shopers
//----------------------------------------------//
Route::get('/shoper',[SAccount::class,'form']);
Route::post('/shoper/signup',[SAccount::class,'signup']);
Route::post('/shoper/signin',[SAccount::class,'signin']);
Route::get('/shoper/signout',[SAccount::class,'signout']);
Route::group(['middleware'=>['sprotected']],function(){
	Route::get('/shoper/products',[Products::class,'shoper_products']);	
	Route::get('/shoper/product/add_form',[Products::class,'add_form']);
	Route::get('/shoper/product/update_form/{id}',[Products::class,'update_form']);
	Route::post('/shoper/product/add',[Products::class,'add']);
	Route::get('/shoper/product/view/{id}',[Products::class,'sview']);
	Route::post('/shoper/product/update/{id}',[Products::class,'update']);	
	Route::get('/shoper/product/delete/{id}',[Products::class,'delete']);	
	
	Route::get('/shoper/account/',[SAccount::class,'view_profile']);
	Route::post('/shoper/account/update/profile',[SAccount::class,'update_profile']);
	Route::post('/shoper/account/update/password',[SAccount::class,'update_password']);
	Route::post('/shoper/account/update/address',[SAccount::class,'update_address']);
	Route::post('/shoper/account/delete',[SAccount::class,'delete_account']);
	//Here You Got Mistake Because of 
	// /shoper/product/{id}
	// /shoper/product/add_form
	// Above two path are same so change it..

	Route::get('/shoper/orders/',[Orders::class,'shoper_orders']);
	Route::get('/shoper/order/proceed/{oid}',[Orders::class,'proceed']);
});
//----------------------------------------------//
//					Admin
//----------------------------------------------//
Route::view('/admin/login','admin.login');
Route::post('/admin/signin',[AAccount::class,'signin']);
Route::get('/admin/signout',[AAccount::class,'signout']);

Route::group(['middleware'=>['aprotected']],function(){
	
	Route::get('/admin',[AAccount::class,'counts']);
	Route::get('/admin/products',[AProducts::class,'products']);
	Route::get('/admin/product/view/{id}',[AProducts::class,'product_details']);
	
	Route::get('/admin/coupons',[Coupons::class,'coupons']);
	Route::post('/admin/coupon/action',[Coupons::class,'action']);
	Route::get('/admin/coupon/delete/{id}',[Coupons::class,'delete']);
	
	Route::get('/admin/complaints',[Complaints::class,'view']);
	Route::get('/admin/complaint/delete/{id}',[Complaints::class,'delete']);
	
	Route::get('/admin/shopers',[Shopers::class,'view']);
	Route::get('/admin/shopers/disable/{id}',[Shopers::class,'disable']);
	Route::get('/admin/shopers/enable/{id}',[Shopers::class,'enable']);
	
	Route::get('/admin/users',[Users::class,'view']);
	Route::get('/admin/users/disable/{id}',[Users::class,'disable']);
	Route::get('/admin/users/enable/{id}',[Users::class,'enable']);
	
	Route::get('/admin/product_category',[Products_Category::class,'view']);
	Route::post('/admin/product_category/action',[Products_Category::class,'action']);
	Route::get('/admin/product_category/delete/{id}',[Products_Category::class,'delete']);

	Route::get('/admin/edu_category',[Edu_Category::class,'view']);
	Route::post('/admin/edu_category/field/action',[Edu_Category::class,'action']);
	Route::get('/admin/edu_category/field/delete/{field}',[Edu_Category::class,'delete']);
	Route::get('/admin/edu_category/field/view/{id}',
		[Edu_Category::class,'view_branches']);
	
	Route::get('/admin/slider',[Slider::class,'view']);
	Route::post('/admin/slider/add',[Slider::class,'add']);
	Route::post('/admin/slider/update/{id}',[Slider::class,'update']);
	Route::get('/admin/slider/delete/{id}',[Slider::class,'delete']);
	
	Route::get('/admin/orders',[AOrders::class,'view']);
});
//----------------------------------------------//
//					General Route
//----------------------------------------------//
Route::get('/find_city/{state}',[UAccount::class,'find_city']);
Route::get('/find_branch/{field}',[UAccount::class,'find_branches']);
