<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\CompositesModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;

class CompositesController extends BaseController
{
    private $composites_model = null;

    function __construct() {
        $this->composites_model = new CompositesModel();
    }

    public function handleGetInfoForManufacturer(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->composites_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->composites_model->getDefaultRecordsPerPage();
        $this->composites_model->setPaginationOptions($page, $page_size);

        $composites = $this->composites_model->getManufacturerDetails($filters);
        
        return $this->prepareOkResponse($response, (array)$composites);
    }

    public function handleGetEmissionsByCarModel(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->composites_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->composites_model->getDefaultRecordsPerPage();
        $this->composites_model->setPaginationOptions($page, $page_size);

        $composites = $this->composites_model->getEmissions($filters);
        
        return $this->prepareOkResponse($response, (array)$composites);
    }

}