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
        
        // $validation_response = $this->isValidPagingParams($filters);
        // if($validation_response === true){
        //     $this->manufacturers_model->setPaginationOptions(
        //         $filters['page'],
        //         $filters['page_size']
        //     );
        // }else{
        //     // throw new HttpBadRequestException($request,$validation_response);
        // }
        
        $models = $this->models_model->getAll($filters);

        // $response->getBody()->write($films_json);
        // return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        return $this->prepareOkResponse($response, (array)$models);
    }
}
