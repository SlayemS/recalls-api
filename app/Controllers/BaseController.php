<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Validator;

class BaseController
{
    protected function prepareOkResponse(Response $response, array $data, int $status_code = 200)
    {
        // var_dump($data);
        $json_data = json_encode($data);
        //-- Write JSON data into the response's body.        
        $response->getBody()->write($json_data);
        return $response->withStatus($status_code)->withAddedHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON);
    }
    
    protected function isValidPagingParams(array $paging_params) : mixed {
        $rules = array(
            'page' => [
                'required',
                'numeric',
                ['min', 1]
            ],
            'page_size' => [
                'required',
                'integer',
                ['min', 5],
                ['max', 50]
            ]
        );

        return $this->isValidData($paging_params, $rules);
    }

    protected function isValidCreateRecall(array $data) : mixed {
        $rules = array(
            'model_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'description' => [
                'required',
                ['lengthMax', 150]
            ],
            'issue_date' => [
                'required',
                ['date', 'Y-m-d']
            ],
            'fix_date' => [
                'required',
                ['date', 'Y-m-d']
            ],
            'subject' => [
                'required',
                ['lengthMax', 50]
            ],
            'component' => [
                'required',
                ['lengthMax', 30]
            ]
        );

        return $this->isValidData($data, $rules);
    }

    protected function isValidUpdateRecall(array $data) : mixed {
        $rules = array(
            'recall_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'model_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'description' => [
                'required',
                ['lengthMax', 150]
            ],
            'issue_date' => [
                'required',
                ['date', 'Y-m-d']
            ],
            'fix_date' => [
                'required',
                ['date', 'Y-m-d']
            ],
            'subject' => [
                'required',
                ['lengthMax', 50]
            ],
            'component' => [
                'required',
                ['lengthMax', 30]
            ]
        );

        return $this->isValidData($data, $rules);
    }

    protected function isValidCreateModel(array $data) : mixed {
        $rules = array(
            'model_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'manufacturer_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'manufacturer_name' => [
                'required',
                ['lengthMax', 50]
            ],
            'country' => [
                'required',
                ['lengthMax', 20]
            ],
            'city' => [
                'required',
                ['lengthMax', 20]
            ],
            'founded_year' => [
                'required',
                'integer',
                ['min', 1900],
                ['max', 2023]
            ],
            'website' => [
                'required',
                ['lengthMax', 100000000]
            ]    
        );
            return $this->isValidData($data, $rules);
    }

    protected function isValidUpdateModel(array $data) : mixed {
        $rules = array(
            'model_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'manufacturer_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'manufacturer_name' => [
                'required',
                ['lengthMax', 50]
            ],
            'country' => [
                'required',
                ['lengthMax', 20]
            ],
            'city' => [
                'required',
                ['lengthMax', 20]
            ],
            'founded_year' => [
                'required',
                'integer',
                ['min', 1900],
                ['max', 2023]
            ],
            'website' => [
                'required',
                ['lengthMax', 100000000]
            ]    
        );
            return $this->isValidData($data, $rules);
    }

    protected function isValidCreateManufacturer(array $data) : mixed {
        $rules = array(
            
            'manufacturer_name' => [
                'required',
                ['lengthMax', 100]
            ],
            'country' => [
                'required',
                ['lengthMax', 50]
            ],
            'city' => [
                'required',
                ['lengthMax', 50]
            ],
            'founded_year' => [
                'required',
                ['date', 'Y']
            ],
            'website' => [
                'required',
                ['lengthMax', 75]
            ]
        );

        return $this->isValidData($data, $rules);
    }

    protected function isValidUpdateManufacturer(array $data) : mixed {
        $rules = array(
            'manufacturer_id' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 100000000]
            ],
            'manufacturer_name' => [
                ['lengthMax',100]
            ],
            'country' => [
                ['lengthMax',50]
            ],
            'city' => [
                ['lengthMax',50]
            ],
            'founded_year' => [
                'integer',
                ['date','Y']
            ],
            'website' => [
                ['lengthMax',75]
            ],
            
            
        );

        return $this->isValidData($data, $rules);
    }

    protected function isValidData(array $data, array $rules) : mixed {
        $validator = new Validator($data, [], 'en');
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            return true;
        }

        return $validator->errorsToJson();
    }

}
