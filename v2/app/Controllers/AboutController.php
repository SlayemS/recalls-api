<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * AboutController
 *
 * Controller for the about page
 */
class AboutController extends BaseController
{
    /**
     * Handle the about page
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response json response of a list of resources
     */
    public function handleAboutApi(Request $request, Response $response, array $uri_args)
    {
        $data = array(
            'about' => 'Welcome, this is a Web service that provides information about car manufacturers, models, recalls, repairs, and customers.',
            'resources' => array(
                'manufacturers' => 'Get all manufacturers',
                'models' => 'Get all models',
                'recalls' => 'Get all recalls',
                'repairs' => 'Get all repairs',
                'customers' => 'Get all customers',
                'cars' => 'Get all cars',
                'instances' => 'Get all instances',
                'instances/{instance_id}/repairs' => 'Get all repairs for a specific instance',
                'cars/{car_id}/instance' => 'Get a specific instance for a specific car'
            ),
        );
        return $this->prepareOkResponse($response, $data);
    }
}
