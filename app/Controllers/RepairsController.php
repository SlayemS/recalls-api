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

    private array $rules = array(
        // Rules for validating Recalls' properties
    );

    public function __construct() {
        $this->repairs_model = new RepairsModel();
    }

    public function handleGetFilms(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        // $page = $filters['page'];
        // $page_size = $filters['page_size'];
        $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->films_model->getDefaultCurrentPage();
        $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->films_model->getDefaultRecordsPerPage();

        $this->films_model->setPaginationOptions($page, $page_size);

        $films = $this->films_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$films);
    }

    // take the above code and make it work for repairs
    public function handleGetRepairs(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        // $page = $filters['page'];
        // $page_size = $filters['page_size'];
        // $page = (array_key_exists('page', $filters)) ? $filters['page'] : $this->repairs_model->getDefaultCurrentPage();
        // $page_size = (array_key_exists('page_size', $filters)) ? $filters['page_size'] : $this->repairs_model->getDefaultRecordsPerPage();

        // $this->repairs_model->setPaginationOptions($page, $page_size);

        $repairs = $this->repairs_model->getAll($filters);

        return $this->prepareOkResponse($response, (array)$repairs);
    }

}
