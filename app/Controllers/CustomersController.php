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

    // ROUTE: / DELETE Customers
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
