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

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->cars_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->cars_model->getDefaultRecordsPerPage();
        $this->cars_model->setPaginationOptions($page, $page_size);

        $cars = $this->cars_model->getAll($filters);
        
        return $this->prepareOkResponse($response, (array)$cars);
    }


    public function handleGetInstanceByCarId(Request $request, Response $response, array $uri_args)
    {
        $instance = $this->cars_model->getInstanceByCarId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$instance);
    }

}
