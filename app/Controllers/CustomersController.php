<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\CustomersModel;

class CustomersController extends BaseController
{

    private $customers_model = null;

    public function __construct(){
        $this->customers_model = new CustomersModel();
    }


    public function handleGetCustomers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        $customers = $this->customers_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$customers);
    }
}
