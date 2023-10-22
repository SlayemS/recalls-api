<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\CarsModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;

class CarsController extends BaseController
{
    private $cars_model = null;

    function __construct() {
        $this->cars_model = new CarsModel();
    }

    public function handleGetCars(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $cars = $this->cars_model->getAll($filters);
        
        $cars_json = json_encode($cars);
        
        $response->getBody()->write($cars_json);
        return $response;
    }


    public function handleGetInstanceByCarId(Request $request, Response $response, array $uri_args)
    {
        $instance = $this->cars_model->getInstanceByCarId($uri_args);
        
        $instance_json = json_encode($instance);
        
        $response->getBody()->write($instance_json);
        return $response;
    }

}
