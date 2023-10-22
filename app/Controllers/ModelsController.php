<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\ModelsModel;

class ModelsController extends BaseController
{
    private $models_model = null;

    public function __construct(){
        $this->models_model = new ModelsModel();
    }


    public function handleGetModels(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        $models = $this->models_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$models);
    }
}
