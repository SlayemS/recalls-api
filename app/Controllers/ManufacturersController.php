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

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->manufacturers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->manufacturers_model->getDefaultRecordsPerPage();
        $this->manufacturers_model->setPaginationOptions($page, $page_size);

        return $this->prepareOkResponse($response, (array)$manufacturers);
    }

    public function handleGetModelsByManufacturerId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->manufacturers_model->getModelsByManufacturerId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }
}
