<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\CompositesModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;

/**
 * CompositesController
 *
 * Controller for the composites page
 */
class CompositesController extends BaseController
{
    private $composites_model = null;

    function __construct() {
        $this->composites_model = new CompositesModel();
    }

    /**
     * Handle get more details for a manufacturer
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response json response of more details for a given manufacturer
     */
    public function handleGetInfoForManufacturer(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->composites_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->composites_model->getDefaultRecordsPerPage();
        $this->composites_model->setPaginationOptions($page, $page_size);

        $composites = $this->composites_model->getManufacturerDetails($filters);
        
        return $this->prepareOkResponse($response, (array)$composites);
    }

    /**
     * Handle get emissions for a car model
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args distance, measurement, car model
     * @return Response json response of a car model and emissions calculated by distance traveled
     */
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