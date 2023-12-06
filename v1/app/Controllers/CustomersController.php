<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\CustomersModel;
use Vanier\Api\Models\CarsModel;

class CustomersController extends BaseController
{

    private $customers_model = null;
    private $cars_model = null;

    public function __construct(){
        $this->customers_model = new CustomersModel();
        $this->cars_model = new CarsModel();
    }


    public function handleGetCustomers(Request $request, Response $response, array $uri_args)
    {               
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->customers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->customers_model->getDefaultRecordsPerPage();
        $this->customers_model->setPaginationOptions($page, $page_size);

        $customers = $this->customers_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$customers);
    }

    public function handleGetCarByCustomerId(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();
        $car = $this->customers_model->getCarByCustomerId($uri_args);

        //$filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->customers_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->customers_model->getDefaultRecordsPerPage();
        $this->customers_model->setPaginationOptions($page, $page_size);
        //$car = $this->cars_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$car);
    }

    public function handleCreateCustomer(Request $request, Response $response){
        $data = $request->getParsedBody();

        if(empty($data) || !isset($data)){
            throw new HttpBadRequestException($request, "Couldn't process the request. The list of customer is empty");
        }


        foreach($data as $key => $customer){
            $validation_response = $this->isValidCreateCustomers($customer);
            if($validation_response === true){
                $this->customers_model->createCustomer($customer);
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
            "message" => "The customer has been successfully created"
        );

        return $this->prepareOkResponse($response, $response_data, HttpCodes::STATUS_CREATED);  

    }

    public function handleUpdateCustomer(Request $request, Response $response){
        $update_data = $request->getParsedBody();

        if(empty($update_data || !isset($update_data))){
            throw new HttpBadRequestException($request, "Couldn't process the request. The update values are empty");
        }

        foreach($update_data as $key => $data){
            $customer_id = $data["customer_id"];

            $id_exists = !empty($this->customers_model->checkIfCustomerExists($customer_id));
            
            if($id_exists){
                $validation_response = $this->isValidUpdateCustomers($data);
                
                if($validation_response === true){
                    array_shift($data);
                    $this->customers_model->updateCustomer($data,$customer_id);
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
                    "message" => "The customer with id " . $customer_id . " does not exist."
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
            "message" => "The list of customer has been successfully updated"
            );
        
        return $this->prepareOkResponse($response,$response_data, HttpCodes::STATUS_CREATED);
    }

    // ROUTE: / DELETE Customers/{customer_id}
    public function handleDeleteCustomer(Request $request, Response $response, array $uri_args)
    {
        $customer_id = $uri_args['customer_id'];

        $validate_id_exist = !empty($this->customers_model->checkIfCustomerExists($customer_id));
        if ($validate_id_exist) {
            $this->customers_model->deleteCustomer($customer_id);
        } else {
            $response_data = array(
                "code" => 404,
                "message" => "The customer with id " . $customer_id . " does not exist."
            );
    
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_NOT_FOUND
            );
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_OK,
            'message' => 'Customer has been successfully deleted'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_OK
        );
    }
}
