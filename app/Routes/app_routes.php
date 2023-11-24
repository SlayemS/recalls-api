<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\HttpNotFoundException;
use Vanier\Api\Controllers\AboutController;
use Vanier\Api\Controllers\ManufacturersController;
use Vanier\Api\Controllers\ModelsController;
use Vanier\Api\Controllers\CarsController;
use Vanier\Api\Controllers\InstancesController;
use Vanier\Api\Controllers\RepairsController;
use Vanier\Api\Controllers\CustomersController;
use Vanier\Api\Controllers\RecallsController;
use Vanier\Api\Controllers\AccountsController;

// Import the app instance into this file's scope.
global $app;

// NOTE: Add your app routes here.
// The callbacks must be implemented in a controller class.
// The Vanier\Api must be used as namespace prefix. 

// ROUTE: GET /
$app->get('/', [AboutController::class, 'handleAboutApi']); 

// ROUTE: GET /hello
$app->get('/hello', function (Request $request, Response $response, $args) {

    $response->getBody()->write("Reporting! Hello there!");
    return $response;
});

// ROUTE: GET /manufacturers
$app->get('/manufacturers', [ManufacturersController::class, 'handleGetManufacturers']); 
// ROUTE: POST /manufacturers
$app->post('/manufacturers', [ManufacturersController::class, 'handleCreateManufacturers']); 
// ROUTE: PUT /manufacturers
$app->put('/manufacturers', [ManufacturersController::class, 'handleUpdateManufacturers']); 
// ROUTE: GET /models by manufacturer_id
$app->get('/manufacturers/{manufacturer_id}/models', [ManufacturersController::class, 'handleGetModelsByManufacturerId']);
// ROUTE: DELETE /manufacturers
$app->delete('/manufacturers/{manufacturer_id}', [ManufacturersController::class,'handleDeleteManufacturers']);

// ROUTE: GET /models
$app->get('/models', [ModelsController::class, 'handleGetModels']);
// ROUTE: POST /models
$app->post('/models', [ModelsController::class, 'handleCreateModels']);
// ROUTE: PUT /models
$app->put('/models', [ModelsController::class, 'handleUpdateModels']);
// ROUTE: GET /cars by model_id
$app->get('/models/{model_id}/cars', [ModelsController::class, 'handleGetCarsByModelId']);
// ROUTE: GET /recalls by model_id
$app->get('/models/{model_id}/recalls', [ModelsController::class, 'handleGetRecallsByModelId']);
// ROUTE: DELETE /models
$app->delete('/models', [ModelsController::class,'handleDeleteModels']);

// ROUTE: GET /repairs
$app->get('/repairs', [RepairsController::class, 'handleGetRepairs']);
// ROUTE: POST /repairs
$app->post('/repairs', [RepairsController::class, 'handleCreateRepairs']);
// ROUTE: PUT /repairs
$app->put('/repairs', [RepairsController::class, 'handleUpdateRepairs']);
// ROUTE: DELETE /repairs/{repair_id}
$app->delete('/repairs/{repair_id}', [RepairsController::class, 'handleDeleteRepairs']);

// ROUTE: GET /recalls
$app->get('/recalls', [RecallsController::class, 'handleGetRecalls']);
// ROUTE: GET /recalls/{recall_id}/instance
$app->get('/recalls/{recall_id}/instance', [RecallsController::class, 'handleGetInstanceByRecallId']);
// ROUTE: POST /recalls
$app->post('/recalls', [RecallsController::class, 'handleCreateRecalls']);
// ROUTE PUT /recalls
$app->put('/recalls', [RecallsController::class, 'handleUpdateRecalls']);

// ROUTE: GET /customers
$app->get('/customers', [CustomersController::class, 'handleGetCustomers']);

$app->get('/customers/{customer_id}/cars', [CustomersController::class, 'handleGetCarByCustomerId']);
// ROUTE: DELETE /customers
$app->delete('/customers/{customer_id}', [CustomersController::class,'handleDeleteCustomer']);

// ROUTE: GET /cars
$app->get('/cars', [CarsController::class, 'handleGetCars']);

$app->get('/cars/{car_id}/instances', [CarsController::class, 'handleGetInstanceByCarId']);

// ROUTE: /instances
// GET
$app->get('/instances', [InstancesController::class, 'handleGetInstances']);

$app->get('/instances/{instance_id}/repairs', [InstancesController::class, 'handleGetRepairsByInstanceId']);

// POST
$app->post('/instances', [InstancesController::class, 'handleCreateInstances']);

// PUT
$app->put('/instances', [InstancesController::class, 'handleUpdateInstances']);

// DELETE
$app->delete('/instances/{instance_id}', [InstancesController::class, 'handleDeleteInstanceById']);


// /account
$app->post('/account', [AccountsController::class, 'handleCreateAccount']);

// /token
$app->post('/token', [AccountsController::class, 'handleGenerateToken']);

