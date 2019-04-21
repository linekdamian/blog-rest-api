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

$router->group(['prefix' => 'blog'], function () use ($router) {
    /**
     * Categories
     */
    $router->get('/category', ['uses' => 'CategoryController@index']);
    $router->post('/category', ['uses' => 'CategoryController@store']);
    $router->get('/category/{category}', ['uses' => 'CategoryController@show']);
    $router->put('/category/{category}', ['uses' => 'CategoryController@update']);
    $router->delete('/category/{category}', ['uses' => 'CategoryController@delete']);

    /**
     * Tag
     */
    $router->get('/tag', ['uses' => 'TagController@index']);
    $router->post('/tag', ['uses' => 'TagController@store']);
    $router->get('/tag/{tag}', ['uses' => 'TagController@show']);
    $router->put('/tag/{tag}', ['uses' => 'TagController@update']);
    $router->delete('/tag/{tag}', ['uses' => 'TagController@delete']);

    /**
     * Post
     */
    $router->get('/post', ['uses' => 'PostController@index']);
    $router->post('/post', ['uses' => 'PostController@store']);
    $router->get('/post/{post}', ['uses' => 'PostController@show']);
    $router->put('/post/{post}', ['uses' => 'PostController@update']);
    $router->delete('/post/{post}', ['uses' => 'PostController@delete']);
});
