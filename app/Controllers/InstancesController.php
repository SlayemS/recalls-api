<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\InstancesModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;


class InstancesController extends BaseController
{
    private $instances_model = null;

    private $rules_create = array(
        'recall_id' => [
            'required',
            'integer',
            ['min', 1],
            ['max', 32767]
        ],
        'car_id' => [
            'required',
            'integer',
            ['min', 1],
            ['max', 32767]
        ],
        'notification_date' => [
            'required',
            ['date', 'Y-m-d H:i:s']
        ],
        'instances_note' => [
            'required',
            ['lengthMin', 1],
            ['lengthMax', 100]
        ],
        'bring_in_date' => [
            'required',
            ['date', 'Y-m-d H:i:s']
        ],
        'expected_leave_date' => [
            'required',
            ['date', 'Y-m-d H:i:s']
        ],
        'job_done' => [
            'required',
            'integer',
            ['min', 0],
            ['max', 1]
        ]
    );

    private $rules_update = array(
        'instance_id' => [
            'required',
            'integer',
            ['min', 1],
            ['max', 32767] // max int for a "smallint" in sql
        ],
        'recall_id' => [
            'integer',
            ['min', 1],
            ['max', 32767]
        ],
        'car_id' => [
            'integer',
            ['min', 1],
            ['max', 32767]
        ],
        'notification_date' => [
            ['date', 'Y-m-d H:i:s']
        ],
        'instances_note' => [
            ['lengthMin', 1],
            ['lengthMax', 100]
        ],
        'bring_in_date' => [
            ['date', 'Y-m-d H:i:s']
        ],
        'expected_leave' => [
            ['date', 'Y-m-d H:i:s']
        ],
        'job_done' => [
            'integer',
            ['min', 0],
            ['max', 1]
        ]
    );

    function __construct() {
        $this->instances_model = new InstancesModel();
    }

    public function handleGetInstances(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->instances_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->instances_model->getDefaultRecordsPerPage();
        $this->instances_model->setPaginationOptions($page, $page_size);

        $instances = $this->instances_model->getAll($filters);
        
        return $this->prepareOkResponse($response, (array)$instances);
    }

    public function handleGetRepairsByInstanceId(Request $request, Response $response, array $uri_args)
    {
        $repairs = $this->instances_model->getRepairsByInstanceId($uri_args);
        
        return $this->prepareOkResponse($response, (array)$repairs);
    }

    public function handleCreateInstances(Request $request, Response $response, array $uri_args) {
        $instances_data = $request->getParsedBody();

        if (empty($instances_data) || !isset($instances_data)) {
            throw new HttpInvalidInputException($request,
            "Couldn't process the request... the list of instances was empty!");
        }


        foreach ($instances_data as $key => $instance) {
            $validation_response = $this->isValidData($instance, $this->rules_create);
            // echo $validation_reponse;
            if ($validation_response === true) {
                $this->instances_model->createInstance($instance); // AAAAAAAAAAAAAAAAAAAAAAAAAAAA

                // TODO ASSIGNMENT: fix throwing exception
                //throw new HttpInvalidInputException($request);
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
            "message" => "The list of instancess has been successfully created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }


    public function handleUpdateInstances(Request $request, Response $response)
    {
        $instances_data = $request->getParsedBody();

        if (empty($instances_data) || !isset($instances_data)) {
            
            // throw new HttpInvalidInputException($request,
            // "Couldn't process the request... the list of instances was empty!");
        }
        

        foreach ($instances_data as $key => $instance) {
            $instance_id = $instance['instance_id'];

            $validate_id_exist = !empty($this->instances_model->checkIfinstanceExists($instance_id));
            if ($validate_id_exist) {
                $validation_response = $this->isValidData($instance, $this->rules_update);

                if ($validation_response === true) {
                    array_shift($instance);
                    $this->instances_model->updateinstance($instance_id, $instance);

                    echo "RAAA";
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
                    "message" => "The instance with id " . $instance_id . " does not exist."
                );
        
                return $this->prepareOkResponse(
                    $response,
                    $response_data,
                    HttpCodes::STATUS_NOT_FOUND
                );
            }
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_OK,
            'message' => 'instances has been successfully updated'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_OK
        );
    }

    public function handleDeleteInstanceById(Request $request, Response $response, array $uri_args)
    {
        print_r($uri_args);
        $instance_id = $uri_args['instance_id'];

        $validate_id_exist = !empty($this->instances_model->checkIfinstanceExists($instance_id));
        if ($validate_id_exist) {
            $this->instances_model->deleteinstance($instance_id);
        } else {
            $response_data = array(
                "code" => 404,
                "message" => "The instance with id " . $instance_id . " does not exist."
            );
    
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_NOT_FOUND
            );
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_OK,
            'message' => 'instance has been successfully deleted'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_OK
        );
    }

}
