<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\RepairsModel;

/**
 * RepairsController
 *
 * Controller for the repairs page
 */
class RepairsController extends BaseController
{
    private $repairs_model = null;

    public function __construct() {
        $this->repairs_model = new RepairsModel();
    }

    /**
     * handleGetRepairs
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response json response of a list of repairs
     */
    public function handleGetRepairs(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->repairs_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->repairs_model->getDefaultRecordsPerPage();
        $this->repairs_model->setPaginationOptions($page, $page_size);

        $repairs = $this->repairs_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$repairs);
    }

    /**
     * handleCreateRepair
     * 
     * @param Request $request
     * @param Response $response
     * @return Response json response of created repairs
     */
    public function handleCreateRepairs(Request $request, Response $response) {
        $repairs_data = $request->getParsedBody();

        if (empty($repairs_data) || !isset($repairs_data)) {
            throw new HttpBadRequestException($request,
            "Couldn't process the request... the list of repairs was empty!");
        }

        foreach ($repairs_data as $key => $repair) {
            $validation_response = $this->isValidCreateRepair($repair);
            if ($validation_response === true) {
                $this->repairs_model->createRepair($repair);
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
            "message" => "The list of repairs has been successfully created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    /**
     * handleUpdateRepairs
     * 
     * @param Request $request
     * @param Response $response
     * @return Response json response of updated repairs
     */
    public function handleUpdateRepairs(Request $request, Response $response)
    {
        $repairs_data = $request->getParsedBody();

        if (empty($repairs_data) || !isset($repairs_data)) {
            throw new HttpBadRequestException($request,
            "Couldn't process the request... the list of repairs was empty!");
        }

        foreach ($repairs_data as $key => $repair) {
            $repair_id = $repair['repair_id'];
            $validate_id_exist = !empty($this->repairs_model->checkIfRepairExists($repair_id));
            if ($validate_id_exist) {
                $validation_response = $this->isValidUpdateRepair($repair);

                if ($validation_response === true) {
                    array_shift($repair);
                    $this->repairs_model->updateRepair($repair_id, $repair);
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
                    "message" => "The repair with id " . $repair_id . " does not exist."
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
            'message' => 'The repair has been successfully updated'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    /**
     * handleDeleteRepair
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args repair_id
     * @return Response json response of deleted repairs
     */
    public function handleDeleteRepair(Request $request, Response $response, array $uri_args)
    {
        $repair_id = $uri_args['repair_id'];

        $validate_id_exist = !empty($this->repairs_model->checkIfRepairExists($repair_id));
        if ($validate_id_exist) {
            $this->repairs_model->deleteRepair($repair_id);
        } else {
            $response_data = array(
                "code" => 404,
                "message" => "The repair with id " . $repair_id . " does not exist."
            );
    
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_NOT_FOUND
            );
        }

        $response_data = array(
            'status' => HttpCodes::STATUS_OK,
            'message' => 'Repair has been successfully deleted'
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_OK
        );
    }

}
