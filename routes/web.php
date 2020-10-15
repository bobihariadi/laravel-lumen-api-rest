<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    // phpinfo();
    return $router->app->version();
});

$router->get('key', 'ExampleController@show');

$router->group(['prefix' => 'api/v1'], function () use ($router) {    
    //posts    
    $router->group(['prefix' => 'posts'], function() use ($router) {
        $router->group([ 'middleware' => 'auth_api_key'], function() use ($router) {
            $router->get('index', 'PostsController@index');
            $router->get('view/{id}', 'PostsController@viewPost');
            $router->delete('delete/{id}', 'PostsController@deletePost');
            $router->put('edit/{id}', 'PostsController@updatePost');
        });
        $router->post('add', 'PostsController@createPost');
        });

    //users
    $router->group(['prefix' => 'users'], function() use ($router) {
        $router->group(['middleware' => 'auth_basic'], function() use ($router) {
            $router->get('view/{id}', 'UsersController@view');
            $router->delete('delete/{id}', 'UsersController@delete');
            $router->put('edit/{id}', 'UsersController@edit');
            $router->get('index', 'UsersController@index'); 
        });
        
        $router->group(['middleware' => 'auth_bearer'], function() use ($router) {
            $router->post('sampleJwt', 'UsersController@sampleJwt');
        });
        
        $router->post('jwt', 'UsersController@jwt');        
        $router->post('add', 'UsersController@add');
    });

    // Index Globals
    $router->group(['prefix' => 'index'], function() use ($router) {
        $router->group(['middleware' => 'auth_bearer'], function() use ($router) {
            $router->post('/', 'IndexController@api');
        });
        $router->post('/show', 'IndexController@show');
    });

    // Store Globals
    $router->group(['prefix' => 'store','middleware' => 'auth_bearer'], function() use ($router) {
        $router->post('/', 'StoreController@api');
    });

});

