<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\HttpNotFoundException;
use Vanier\Api\Controllers\AboutController;
use Vanier\Api\Controllers\ManufacturersController;
use Vanier\Api\Controllers\ModelsController;
use Vanier\Api\Controllers\CarsController;
use Vanier\Api\Controllers\RepairsController;

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

$app->get('/manufacturers', [ManufacturersController::class, 'handleGetManufacturers']); 

$app->get('/models', [ModelsController::class, 'handleGetModels']);

// ROUTE: GET /repairs
$app->get('/repairs', [RepairsController::class, 'handleGetRepairs']);

// ROUTE: GET /recalls
$app->get('/recalls', [RecallsController::class, 'fetchAll']);

// ROUTE: GET /cars
$app->get('/cars', [CarsController::class, 'handleGetCars']);

$app->get('/cars/{car_id}/instance', [CarsController::class, 'handleGetInstanceByCarId']);
