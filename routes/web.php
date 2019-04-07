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

/**
 * Categories
 */
$router->get('/category', ['as' => 'category.index', 'uses' => 'CategoryController@index']);
$router->post('/category', ['as' => 'category.store', 'uses' => 'CategoryController@store']);
$router->get('/category/{category}', ['as' => 'category.show', 'uses' => 'CategoryController@show']);
$router->put('/category/{category}', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
$router->delete('/category/{category}', ['as' => 'category.delete', 'uses' => 'CategoryController@delete']);

/**
 * Tag
 */
$router->get('/tag', ['as' => 'tag.index', 'uses' => 'TagController@index']);
$router->post('/tag', ['as' => 'tag.store', 'uses' => 'TagController@store']);
$router->get('/tag/{tag}', ['as' => 'tag.show', 'uses' => 'TagController@show']);
$router->put('/tag/{tag}', ['as' => 'tag.update', 'uses' => 'TagController@update']);
$router->delete('/tag/{tag}', ['as' => 'tag.delete', 'uses' => 'TagController@delete']);

/**
 * Post
 */
$router->get('/post', ['as' => 'post.index', 'uses' => 'PostController@index']);
$router->post('/post', ['as' => 'post.store', 'uses' => 'PostController@store']);
$router->get('/post/{post}', ['as' => 'post.show', 'uses' => 'PostController@show']);
$router->put('/post/{post}', ['as' => 'post.update', 'uses' => 'PostController@update']);
$router->delete('/post/{post}', ['as' => 'post.delete', 'uses' => 'PostController@delete']);
