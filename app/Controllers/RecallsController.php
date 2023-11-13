<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface as HttpCodes;
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
            // throw new HttpInvalidInputException($request,
            // "Couldn't process the request... the list of recalls was empty!");
        }

        foreach ($recalls_data as $key => $recall) {
            $validation_response = $this->isValidData($recall, $this->rules_create);
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
}
