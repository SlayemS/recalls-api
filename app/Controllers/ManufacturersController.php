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
        
        // $validation_response = $this->isValidPagingParams($filters);
        // if($validation_response === true){
        //     $this->manufacturers_model->setPaginationOptions(
        //         $filters['page'],
        //         $filters['page_size']
        //     );
        // }else{
        //     // throw new HttpBadRequestException($request,$validation_response);
        // }
        
        $manufacturers = $this->manufacturers_model->getAll($filters);

        // $response->getBody()->write($films_json);
        // return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        return $this->prepareOkResponse($response, (array)$manufacturers);
    }
}
