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

        $instances = $this->instances_model->getAll($filters);
        
        $instances_json = json_encode($instances);
        
        $response->getBody()->write($instances_json);
        return $response;
    }

    public function handleGetRepairsByInstanceId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->instances_model->getRepairsByInstanceId($uri_args);
        
        $repairs_json = json_encode($repairs);
        
        $response->getBody()->write($repairs_json);
        return $response;
    }

}
