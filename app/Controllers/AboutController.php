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
                'manufacturers' => 'Get all manufacturers',
                'models' => 'Get all models',
                'recalls' => 'Get all recalls',
                'repairs' => 'Get all repairs',
                'customers' => 'Get all customers',
                'cars' => 'Get all cars',
                'instances' => 'Get all instances',
                'instances/{instance_id}/repairs' => 'Get all repairs for a specific instance',
                'cars/{car_id}/instance' => 'Get a specific instance for a specific car',
                'manufacturers' => 'Filters: country, city, year',
                'models' => 'Filters: year, vehicle_type, fuel_type, transmission_type, engine, power_type',
                'recalls' => 'Filters: subject, issue_date, component',
                'repairs' => 'Filters: status, max_cost, min_cost',
                'customers' => 'Filters: first_name, last_name, customer_id',
                'cars' => 'Filters: dealership, color, max_mileage, min_mileage, customer_id',
                'instances' => 'Filters: job_done',
            ),
        );
        return $this->prepareOkResponse($response, $data);
    }
}
