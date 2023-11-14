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
            throw new HttpBadRequestException($request, "Couldn't proccess the request. The list of manufacturers is empty");
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

        if(empty($update_data || !isset($update_data))){
            throw new HttpBadRequestException($request, "Couldn't proccess the request. The update values are empty");
        }

        foreach($update_data as $key => $data){
            $manufacturer_id = $data["manufacturer_id"];
            
            $id_exists = !empty($this->manufacturers_model->ifManufacturerExists($manufacturer_id));
            
            if($id_exists){
                $validation_response = $this->isValidUpdateManufacturer($data);

                if($validation_response === true){
                    $this->manufacturers_model->updateManufacturer($data,$manufacturer_id);
                }else{
                    $response_data = array(
                        "code" => 442,
                        "message" => $validation_response
                    );
            
                    return $this->prepareOkResponse(
                        $response,
                        $response_data,
                        HttpCodes::STATUS_UNPROCESSABLE_ENTITY
                    );
                }
                
            }else {
                $response_data = array(
                    "code" => 404,
                    "message" => "The manufacturer with id " . $manufacturer_id . " does not exist."
                );
        
                return $this->prepareOkResponse(
                    $response,
                    $response_data,
                    HttpCodes::STATUS_NOT_FOUND
                );
            }
        }

        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "The list of manufacturer has been successfully updated"
            );
        
        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);
    }

    public function handleDeleteManufacturers(Request $request, Response $response)
    {
        $manufacturers_id = $request->getParsedBody();

        foreach($manufacturers_id as $key => $where){

        }    
        if($this->isValidData($where, $this->rules)){
            $this->manufacturers_model->deleteManufacturer($where);
        }else{
                //TODO: add $validation_response to the list of errors.
        }
        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "Deleted!"
        );

        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);

    }
}
