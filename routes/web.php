<?php

//dashboard
Route::get('/', 'InvoiceController@index');

//product details
Route::get('/product/{id}', 'ProductController@getProductDetails');

//resource endpoints for invoice
Route::resource('invoice', 'InvoiceController');
