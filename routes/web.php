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

$router->post('auth/login', ['uses' => 'AuthController@login']);

$router->group(['prefix' => '{lang}', 'middleware' => 'locale'], function () use ($router) {
    /**
     * Categories
     */
    $router->get('/category', ['uses' => 'CategoryController@index']);
    $router->get('/category/{category}', ['uses' => 'CategoryController@show']);
    /**
     * Tags
     */
    $router->get('/tag', ['uses' => 'TagController@index']);
    $router->get('/tag/{tag}', ['uses' => 'TagController@show']);
    /**
     * Posts
     */
    $router->get('/post', ['uses' => 'PostController@index']);
    $router->get('/post/{post}', ['uses' => 'PostController@show']);
});

// TODO JWT
// $router->group(['middleware' => 'jwt'], function () use ($router) {
    $router->post('/category', ['uses' => 'CategoryController@store']);
    $router->put('/category/{category}', ['uses' => 'CategoryController@update']);
    $router->delete('/category/{category}', ['uses' => 'CategoryController@delete']);

    $router->post('/tag', ['uses' => 'TagController@store']);
    $router->put('/tag/{tag}', ['uses' => 'TagController@update']);
    $router->delete('/tag/{tag}', ['uses' => 'TagController@delete']);

    $router->post('/post', ['uses' => 'PostController@store']);
    $router->put('/post/{post}', ['uses' => 'PostController@update']);
    $router->delete('/post/{post}', ['uses' => 'PostController@delete']);
// });
