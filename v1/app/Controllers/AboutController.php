<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AboutController extends BaseController
{
    public function handleAboutApi(Request $request, Response $response, array $uri_args)
    {
        $data = array(
            'about' => 'Welcome, this is a Web service that provides information about car manufacturers, models, recalls, repairs, and customers.',
            'resources' => array(
                'manufacturers' => ['Description' => 'Get all manufacturers','Filters' => 'year, vehicle_type, fuel_type, transmission_type, engine, power_type' ],
                'models' => ['Description' => 'Get all models', 'Filters' => 'year, vehicle_type, fuel_type, transmission_type, engine, power_type' ],
                'recalls' => ['Description' => 'Get all recalls','Filters' => 'subject, issue_date, component' ],
                'repairs' => ['Description' => 'Get all repairs', 'Filters' => 'status, max_cost, min_cost'],
                'customers' => ['Description' => 'Get all customers', 'Filters' => 'first_name, last_name, customer_id'],
                'cars' => ['Description' => 'Get all cars', 'Filters' => 'dealership, color, max_mileage, min_mileage, customer_id'],
                'instances' => ['Description' => 'Get all instances', 'Filters' => 'job_done'],
                'instances/{instance_id}/repairs' => 'Get all repairs for a specific instance',
                'cars/{car_id}/instance' => 'Get a specific instance for a specific car'
            ),
        );
        return $this->prepareOkResponse($response, $data);
    }
}
