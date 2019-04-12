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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
    
$router->post('load_wine',['uses' => 'RssController@readRss']);
$router->post('update_wine',['uses' => 'RssController@updateWine']);

$router->get('home', ['uses' => 'HomeController@inicio']);
$router->post('principal',['uses' => 'HomeController@recibir']);
$router->post('show', ['uses' => 'HomeController@show']);

