<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ShoppingController;

//AUTHORS
$router->get('/login', function(){ return "<h1>Welcome to STANZA  - Socool Tourism AdmiNistrator Zero Anxiety</h1>";
});

$router->get('/customers', 'CustomerController@index');
$router->get('/customers/{customer}','CustomerController@show');

//BOOKINGS

$router->get('/bookings', 'BookingController@index');
$router->get('/bookings/{single_booking}', 'BookingController@show');
$router->get('bookings/all_book/{customer_id}','BookingController@allbookings');

$router->post('/customers','CustomerController@store');
$router->post('/bookings','BookingController@store');

$router->put('/customers/{customer}','CustomerController@update');
$router->patch('/customers/{customer}','CustomerController@update');
$router->delete('/customers/{customer}','CustomerController@destroy');

//SHOPPING LIST

$router->get('/shopping_list','ShoppingController@index');
$router->post('/shopping_list','ShoppingController@store');