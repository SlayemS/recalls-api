<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpLogicException extends HttpSpecializedException
{
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = 'Logic Exception';

    protected string $description = 'Errors related to environmental setup or malformed JWT keys';
}
