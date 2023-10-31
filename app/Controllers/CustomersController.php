<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\CustomersModel;
use Vanier\Api\Models\CarsModel;

class CustomersController extends BaseController
{

    private $customers_model = null;
    private $cars_model = null;

    public function __construct(){
        $this->customers_model = new CustomersModel();
        $this->cars_model = new CarsModel();
    }


    public function handleGetCustomers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->customers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->customers_model->getDefaultRecordsPerPage();
        $this->customers_model->setPaginationOptions($page, $page_size);

        $customers = $this->customers_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$customers);
    }

    public function handleGetCarByCustomerId(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();
        $car = $this->customers_model->getCarByCustomerId($uri_args);

        //$filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->customers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->customers_model->getDefaultRecordsPerPage();
        $this->customers_model->setPaginationOptions($page, $page_size);
        //$car = $this->cars_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$car);
    }
}
