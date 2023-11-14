<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Exceptions\HttpInvalidInputException;
use Vanier\Api\Models\RecallsModel;

class RecallsController extends BaseController
{

    private $recalls_model = null;

    public function __construct(){
        $this->recalls_model = new RecallsModel();
    }


    public function handleGetRecalls(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->recalls_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->recalls_model->getDefaultRecordsPerPage();
        $this->recalls_model->setPaginationOptions($page, $page_size);

        $recalls = $this->recalls_model->getAll($filters);
        return $this->prepareOkResponse($response, (array)$recalls);
    }

    public function handleGetInstanceByRecallId(Request $request, Response $response, array $uri_args)
    {
        $instance = $this->recalls_model->getInstanceByRecallId($uri_args);
        return $this->prepareOkResponse($response, (array)$instance);
    }

    // / POST Recalls
    public function handleCreateRecalls(Request $request, Response $response) {
        $recalls_data = $request->getParsedBody();

        if (empty($recalls_data) || !isset($recalls_data)) {
            throw new HttpBadRequestException($request,
            "Couldn't process the request... the list of recalls was empty!");
        }

        foreach ($recalls_data as $key => $recall) {
            $validation_response = $this->isValidCreateRecall($recall);
            if ($validation_response === true) {
                $this->recalls_model->createRecall($recall);
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
            "message" => "The list of recalls has been successfully created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    // / PUT Recalls
    public function handleUpdateRecalls(Request $request, Response $response)
    {
        $recalls_data = $request->getParsedBody();

        if (empty($recalls_data) || !isset($recalls_data)) {
            throw new HttpBadRequestException($request,
            "Couldn't process the request... the list of recalls was empty!");
        }

        foreach ($recalls_data as $key => $recall) {
            $recall_id = $recall['recall_id'];
            $validate_id_exist = !empty($this->recalls_model->checkIfRecallExists($recall_id));
            if ($validate_id_exist) {
                $validation_response = $this->isValidUpdateRecall($recall);

                if ($validation_response === true) {
                    array_shift($recall);
                    $this->recalls_model->updateRecall($recall_id, $recall);
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
                    "message" => "The recall with id " . $recall_id . " does not exist."
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
            'message' => 'The recall has been successfully updated'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }
}
