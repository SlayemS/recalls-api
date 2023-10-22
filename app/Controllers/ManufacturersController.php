<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\ManufacturersModel;

class ManufacturersController extends BaseController
{

    private $manufacturers_model = null;

    public function __construct(){
        $this->manufacturers_model = new ManufacturersModel();
    }


    public function handleGetManufacturers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        $manufacturers = $this->manufacturers_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$manufacturers);
    }
}
