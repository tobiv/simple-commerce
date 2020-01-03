<?php

Route::get(config('commerce.routes.thanks'), 'Http\Controllers\Web\ThanksController')->name('thanks');
//Route::post(config('commerce.routes.redeem_coupon'), 'Http\Controllers\Web\RedeemCouponController')->name('coupon.redeem');
//Route::get('/{category}', 'Http\Controllers\Web\ProductCategoryController@show')->name('categories.show');

/**
 * Cart
 */

Route::post(config('commerce.routes.cart.add'), 'Http\Controllers\Web\CartController@store')->name('cart.add');
Route::post(config('commerce.routes.cart.clear'), 'Http\Controllers\Web\ClearCartController')->name('cart.clear');
Route::post(config('commerce.routes.cart.delete'), 'Http\Controllers\Web\CartController@destroy')->name('cart.delete');


/**
 * Checkout
 */

Route::get(config('commerce.routes.checkout.show'), 'Http\Controllers\Web\CheckoutController@show')->name('checkout.show');
Route::post(config('commerce.routes.checkout.store'), 'Http\Controllers\Web\CheckoutController@store')->name('checkout.store');

/**
 * Products
 */

Route::get(config('commerce.routes.products.index'), 'Http\Controllers\Web\ProductController@index')->name('products.index');
Route::get(config('commerce.routes.products.search'), 'Http\Controllers\Web\ProductSearchController@index')->name('products.search');
Route::get(config('commerce.routes.products.search').'/results', 'Http\Controllers\Web\ProductSearchController@show')->name('products.search.results');
Route::get(config('commerce.routes.products.show'), 'Http\Controllers\Web\ProductController@show')->name('products.show');
