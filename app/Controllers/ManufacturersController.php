<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\ManufacturersModel;

class ManufacturersController extends BaseController
{

    private $manufacturers_model = null;
    
    private array $rules = array(
        // Rules for validating films' properties
    );

    public function __construct(){
        $this->manufacturers_model = new ManufacturersModel();
    }


    public function handleGetManufacturers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->manufacturers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->manufacturers_model->getDefaultRecordsPerPage();
        $this->manufacturers_model->setPaginationOptions($page, $page_size);
        
        $manufacturers = $this->manufacturers_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$manufacturers);
    }

    public function handleGetModelsByManufacturerId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->manufacturers_model->getModelsByManufacturerId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }

    public function handleCreateManufacturers(Request $request, Response $response){
        $data = $request->getParsedBody();

        if(empty($data) || !isset($data)){
            // throw new HttpBadRequestException($request, "Couldn't proccess the request. The list of manufacturers is empty");
        }


        foreach($data as $key => $manufacturer){
            if($this->isValidData($manufacturer, $this->rules)){
                $this->manufacturers_model->createManufacturer($manufacturer);
            }else{
                //? Else keep track of the encountered errors. We can maintain an array
                // We can maintain an array.
                //TODO: add $validation_response to the list of errors.
            }
        }

        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "The manufacturer has been successfully created"
        );

        return $this->prepareOkResponse($response, $response_data, HttpCodes::STATUS_CREATED);  

    }

    public function handleUpdateManufacturers(Request $request, Response $response,){
        $update_data = $request->getParsedBody();

        $whereArr = [
            $id = [
                "manufacturer_id" => 1
            ]
        ];

        if(empty($update_data || !isset($update_data))){
            throw new HttpBadRequestException($request, "Couldn't proccess the request. The update values are empty");
        }

        foreach($update_data as $key => $data){

        }
        
        foreach($whereArr as $key => $where){

        }


        if($this->isValidData($data, $this->rules)){
            $this->manufacturers_model->updateManufacturer($data,$where);
            
            $response_data = array(
                "code" => HttpCodes::STATUS_CREATED,
                "message" => "The list of manufacturer has been successfully updated"
            );
        }

        

        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);
    }
}
