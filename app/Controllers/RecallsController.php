<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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
}
