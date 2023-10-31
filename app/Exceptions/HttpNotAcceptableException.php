<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpNotAcceptableException extends HttpSpecializedException
{
    protected $code = 406;

    /**
     * @var string
     */
    protected $message = 'Invalid resource';

    protected string $description = 'The application could not accept the parameter as it is invalid';
}
