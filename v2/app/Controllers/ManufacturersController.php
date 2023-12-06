<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\ManufacturersModel;

/**
 * ManufacturersController
 *
 * Controller for the manufacturers page
 */
class ManufacturersController extends BaseController
{

    private $manufacturers_model = null;
    

    public function __construct(){
        $this->manufacturers_model = new ManufacturersModel();
    }

    /**
     * handleGetManufacturers
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response json response of a list of manufacturers
     */
    public function handleGetManufacturers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        
        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->manufacturers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->manufacturers_model->getDefaultRecordsPerPage();
        $this->manufacturers_model->setPaginationOptions($page, $page_size);
        
        $manufacturers = $this->manufacturers_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$manufacturers);
    }

    /**
     * handleGetModelsByManufacturerId
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args manufacturer_id
     * @return Response json response of a list of models of a manufacturer specified by the manufacturer_id
     */
    public function handleGetModelsByManufacturerId(Request $request, Response $response, array $uri_args)
    {
        $manufacturers = $this->manufacturers_model->getModelsByManufacturerId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$manufacturers);
    }

    /**
     * handleCreateManufacturers
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @param $request->getParsedBody() $data list of manufacturers
     * @return Response creates a list of manufacturers
     */
    public function handleCreateManufacturers(Request $request, Response $response){
        $data = $request->getParsedBody();

        if(empty($data) || !isset($data)){
            throw new HttpBadRequestException($request, "Couldn't process the request. The list of manufacturer is empty");
        }

        foreach($data as $key => $manufacturer){
            $validation_response = $this->isValidCreateManufacturer($manufacturer);
            if($validation_response === true){
                $this->manufacturers_model->createManufacturer($manufacturer);
            }else{
                $response_data = array(
                    "code" => 422,
                    "message" => $validation_response
                );
                return $this->prepareOkResponse(
                    $response,
                    $response_data,
                    HttpCodes::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        }

        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "The manufacturer has been successfully created"
        );

        return $this->prepareOkResponse($response, $response_data, HttpCodes::STATUS_CREATED);  

    }

    /**
     * /PUT handleUpdateManufacturers
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @param $request->getParsedBody() $data list of manufacturers
     * @return Response updates a list of manufacturers
     */
    public function handleUpdateManufacturers(Request $request, Response $response){
        $update_data = $request->getParsedBody();

        if(empty($update_data || !isset($update_data))){
            throw new HttpBadRequestException($request, "Couldn't process the request. The update values are empty");
        }

        foreach($update_data as $key => $data){
            $manufacturer_id = $data["manufacturer_id"];

            $id_exists = !empty($this->manufacturers_model->ifManufacturerExists($manufacturer_id));
            
            if($id_exists){
                $validation_response = $this->isValidUpdateManufacturer($data);
                
                if($validation_response === true){
                    array_shift($data);
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

    /**
     * /DELETE handleDeleteManufacturers
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response deletes a manufacturer or not
     */
    public function handleDeleteManufacturers(Request $request, Response $response,array $uri_args)
    {
        $id = $uri_args['manufacturer_id'];
        
        $id_exists = !empty($this->manufacturers_model->ifManufacturerExists($id));

        if($id_exists){
            $this->manufacturers_model->deleteManufacturer($id);
        }else {
            $response_data = array(
                "code" => 404,
                "message" => "The manufacturer with id " . $id . " does not exist."
            );
    
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_NOT_FOUND
            );
        }
        
       
        $response_data = array(
            "code" => HttpCodes::STATUS_OK,
            "message" => "Deleted!"
        );

        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_OK);

    }
}
