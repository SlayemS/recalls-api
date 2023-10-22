<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\RepairsModel;

class RepairsController extends BaseController
{
    private $repairs_model = null;

    private array $rules = array(
        // Rules for validating Recalls' properties
    );

    public function __construct() {
        $this->repairs_model = new RepairsModel();
    }

    public function handleGetRecalls(Request $request, Response $response, array $uri_args)
    {
        
        return $this->prepareOkResponse($response, $data);
    }



}
