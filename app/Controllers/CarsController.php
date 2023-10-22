<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\CarsModel;
use Vanier\Api\Exceptions\HttpInvalidInputException;

class CarsController extends BaseController
{
    private $cars_model = null;

    private $rules_create = array(
        'first_name' => [
            'required',
            ['lengthMin', 1],
            ['lengthMax', 45]
        ],
        'last_name' => [
            'required',
            ['lengthMin', 1],
            ['lengthMax', 45]
        ],
        'last_update' => [
            ['date', 'Y-m-d H:i:s']
        ],
    );

    function __construct() {
        $this->cars_model = new CarsModel();
    }

    public function handleGetCars(Request $request, Response $response, array $uri_args)
    {
        $filters = $request->getQueryParams();

        $cars = $this->cars_model->getAll($filters);
        
        $cars_json = json_encode($cars);
        
        $response->getBody()->write($cars_json);
        return $response;
    }


    public function handleGetInstanceByCarId(Request $request, Response $response, array $uri_args)
    {
        $instance = $this->cars_model->getInstanceByCarId($uri_args);
        
        $instance_json = json_encode($instance);
        
        $response->getBody()->write($instance_json);
        return $response;
    }


    public function handleGetFilmsByActorId(Request $request, Response $response, array $uri_args)
    {
        $film = $this->actors_model->getFilmsByActorId($uri_args);
        
        $film_json = json_encode($film);
        
        $response->getBody()->write($film_json);
        return $response;
    }

    public function handleCreateActors(Request $request, Response $response)
    {
        $actors_data = $request->getParsedBody();

        if (empty($actors_data) || !isset($actors_data)) {
            throw new HttpInvalidInputException($request,
            "Couldn't process the request... the list of films was empty!");
        }


        foreach ($actors_data as $key => $actor) {

            $validation_response = $this->isValidData($actor, $this->rules_create);
            if ($validation_response === true) {
                $actor_id = $this->actors_model->createActor($actor);
                $response->getBody()->write(json_encode(['actor_id' => $actor_id]));
                return $response->withStatus(201);
            }
            else {

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
            "message" => "The list of actors has been successfully created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }
}
