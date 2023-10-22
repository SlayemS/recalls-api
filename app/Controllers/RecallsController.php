<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\RecallsModel;

class RecallsController extends BaseController
{

    private $recalls_model = null;

    public function __construct(){
        $this->recalls_model = new RecallsModel();
    }


    public function handleGetRecalls(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        $recalls = $this->recalls_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$recalls);
    }
}
