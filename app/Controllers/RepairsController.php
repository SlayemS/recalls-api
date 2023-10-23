<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Models\RepairsModel;

class RepairsController extends BaseController
{
    private $repairs_model = null;

    public function __construct() {
        $this->repairs_model = new RepairsModel();
    }

    public function handleGetRepairs(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->repairs_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->repairs_model->getDefaultRecordsPerPage();
        $this->repairs_model->setPaginationOptions($page, $page_size);

        $repairs = $this->repairs_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$repairs);
    }

}
