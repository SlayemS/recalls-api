<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\InstancesModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;


class InstancesController extends BaseController
{
    private $instances_model = null;

    function __construct() {
        $this->instances_model = new InstancesModel();
    }

    public function handleGetInstances(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->instances_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->instances_model->getDefaultRecordsPerPage();
        $this->instances_model->setPaginationOptions($page, $page_size);

        $instances = $this->instances_model->getAll($filters);
        
        return $this->prepareOkResponse($response, (array)$instances);
    }

    public function handleGetRepairsByInstanceId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->instances_model->getRepairsByInstanceId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }

}
