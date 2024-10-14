<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|----------------------------------------------------------------------
| Application Routes
|----------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
// routes/api.php

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('task', 'TaskController@store_task'); // Create a new task
    $router->get('task', 'TaskController@gettasks'); // Retrieve all tasks
    $router->delete('task/{id}', 'TaskController@deleteitem'); // Delete a task by ID
    $router->put('task/{id}', 'TaskController@updatetask'); // Update a task by ID
});


