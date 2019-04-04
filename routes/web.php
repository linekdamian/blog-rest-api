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

$router->get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

$router->get('/category', ['as' => 'category.index', 'uses' => 'CategoryController@index']);
$router->post('/category', ['as' => 'category.store', 'uses' => 'CategoryController@store']);
$router->get('/category/{category}', ['as' => 'category.show', 'uses' => 'CategoryController@show']);
$router->put('/category/{category}', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
$router->delete('/category/{category}', ['as' => 'category.delete', 'uses' => 'CategoryController@delete']);
