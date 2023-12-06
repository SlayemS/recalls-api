<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\CarsModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;

class CarsController extends BaseController
{
    private $cars_model = null;

    function __construct() {
        $this->cars_model = new CarsModel();
    }

    public function handleGetCars(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->cars_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->cars_model->getDefaultRecordsPerPage();
        $this->cars_model->setPaginationOptions($page, $page_size);

        $cars = $this->cars_model->getAll($filters);
        
        return $this->prepareOkResponse($response, (array)$cars);
    }


    public function handleGetInstanceByCarId(Request $request, Response $response, array $uri_args)
    {
        $instance = $this->cars_model->getInstanceByCarId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$instance);
    }

    // / POST Cars
    public function handleCreateCars(Request $request, Response $response) {
        $cars_data = $request->getParsedBody();

        if (empty($cars_data) || !isset($cars_data)) {
            throw new HttpBadRequestException($request, "Couldn't process the request... the list of cars was empty!");
        }

        foreach ($cars_data as $key => $car) {
            $validation_response = $this->isValidCreateCar($car);
            if ($validation_response === true) {
                $this->cars_model->createCar($car);
            } else {
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
            "message" => "The list of cars has been successfully created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    // / PUT Cars
    public function handleUpdateCars(Request $request, Response $response)
    {
        $cars_data = $request->getParsedBody();

        if (empty($cars_data) || !isset($cars_data)) {
            throw new HttpBadRequestException($request, "Couldn't process the request... the list of cars was empty!");
        }

        foreach ($cars_data as $key => $car) {
            $car_id = $car['car_id'];
            $validate_id_exist = !empty($this->cars_model->checkIfCarExists($car_id));
            if ($validate_id_exist) {
                $validation_response = $this->isValidUpdateCar($car);

                if ($validation_response === true) {
                    array_shift($car);
                    $this->cars_model->updateCar($car_id, $car);
                } else {
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
            } else {
                $response_data = array(
                    "code" => 404,
                    "message" => "The car with id " . $car_id . " does not exist."
                );
        
                return $this->prepareOkResponse(
                    $response,
                    $response_data,
                    HttpCodes::STATUS_NOT_FOUND
                );
            }
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_CREATED,
            'message' => 'The car has been successfully updated'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    // / DELETE Cars/{car_id}
    public function handleDeleteCar(Request $request, Response $response, array $uri_args)
    {
        $car_id = $uri_args['car_id'];

        $validate_id_exist = !empty($this->cars_model->checkIfCarExists($car_id));
        if ($validate_id_exist) {
            $this->cars_model->deleteCar($car_id);
        } else {
            $response_data = array(
                "code" => 404,
                "message" => "The car with id " . $car_id . " does not exist."
            );
    
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_NOT_FOUND
            );
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_OK,
            'message' => 'Car has been successfully deleted'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_OK
        );
    }

}
