<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

use TodoAPI\Controller;

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();
$app->config('debug', false);

// report 500 error on DB exceptions
$app->error(function (\PDOException $e) use ($app) {
    
});

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

/* ROUTING
GET /api/v1/tasks
GET /api/v1/tasks/:page

GET /api/v1/task/:id

POST /api/v1/task

PUT /api/v1/task/:id

DELETE /api/v1/task/:id
*/
// API group
$app->group('/api', function () use ($app) {
 
    // VERSION group
    $app->group('/v1', function () use ($app) {

        // LIST of Tasks objects (default first page)
        $app->get('/tasks', function () use ($app) {
            (new Controller())->taskListAction($app);
        });

        // SINGLE Task object
        $app->get('/task/:id', function ($id) use ($app) {
            (new Controller())->taskAction($app, $id);
        });

        // CREATION of Task object
        $app->post('/task', function () use ($app) {
            // load POST body
            $xml = $app->request()->getBody();
            
            (new Controller())->taskCreateAction($app, $xml);
        });
 
        // UPDATE of Task object
        $app->put('/task/:id', function ($id) use ($app) {
            // load POST body
            $xml = $app->request()->getBody();
            
            (new Controller())->taskUpdateAction($app, $id, $xml);
        });
 
        // DELETION of Task object
        $app->delete('/task/:id', function ($id) use ($app) {
            (new Controller())->taskDeleteAction($app, $id);
        });
    });
});


// User-friendly interface
$app->get(
    '/',
    function () use ($app) {
        (new Controller())->frontAction($app);
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
