<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpAuthenticationException extends HttpSpecializedException
{
    protected $code = 401;

    /**
     * @var string
     */
    protected $message = 'Expired Token';

    protected string $description = 'Too much time has passed. The token has expired';
}
