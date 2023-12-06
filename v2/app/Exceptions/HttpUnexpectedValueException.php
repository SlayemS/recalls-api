<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpUnexpectedValueException extends HttpSpecializedException
{
    protected $code = 417;

    /**
     * @var string
     */
    protected $message = 'Unexpected Value';

    protected string $description = 'Errors having to do with JWT signature and claims';
}
