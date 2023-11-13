<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\ModelsModel;

class ModelsController extends BaseController
{
    private $models_model = null;

    private array $rules = array(
        // Rules for validating films' properties
    );

    public function __construct(){
        $this->models_model = new ModelsModel();
    }


    public function handleGetModels(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();
        

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->models_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->models_model->getDefaultRecordsPerPage();
        $this->models_model->setPaginationOptions($page, $page_size);
        
        $models = $this->models_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$models);
    }

    public function handleGetCarsByModelId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->models_model->getCarsByModelId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }

    public function handleGetRecallsByModelId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->models_model->getRecallsByModelId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }

    public function handleCreateModels(Request $request, Response $response){
        $data = $request->getParsedBody();

        if(empty($data) || !isset($data)){
            // throw new HttpBadRequestException($request, "Couldn't proccess the request. The list of manufacturers is empty");
        }


        foreach($data as $key => $model){
            if($this->isValidData($model, $this->rules)){
                $this->models_model->createModel($model);
            }else{
                //? Else keep track of the encountered errors. We can maintain an array
                // We can maintain an array.
                //TODO: add $validation_response to the list of errors.
            }
        }

        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "The model has been successfully created"
        );

        return $this->prepareOkResponse($response, $response_data, HttpCodes::STATUS_CREATED);  

    }

    public function handleDeleteModels(Request $request, Response $response)
    {
        $models_id = $request->getParsedBody();

        foreach($models_id as $key => $where){

        }    
        if($this->isValidData($where, $this->rules)){
            $this->models_model->deleteModel($where);
        }else{
                //TODO: add $validation_response to the list of errors.
        }
        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "Deleted!"
        );

        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);

    }

    public function handleUpdateModels(Request $request, Response $response,){
        $update_data = $request->getParsedBody();

        $whereArr = [
            $id = [
                "model_id" => 1
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
            $this->models_model->updateModel($data,$where);
            
            $response_data = array(
                "code" => HttpCodes::STATUS_CREATED,
                "message" => "The list of model has been successfully updated"
            );
        }
        

        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);
    }
}
