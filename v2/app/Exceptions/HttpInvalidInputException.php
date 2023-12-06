<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidInputException extends HttpSpecializedException
{
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = 'Invalid Input';

    protected string $description = 'Input given is not valid';
}
