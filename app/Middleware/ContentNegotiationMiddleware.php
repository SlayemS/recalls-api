<?php

namespace Vanier\Api\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Vanier\Api\Exceptions\HttpNotAcceptableException;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
        
    /**
     * process
     *
     * @param  mixed $request
     * @param  mixed $handler
     * @return ResponseInterface
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
       
        $headerValueArray = $request->getHeaderLine('Accept');

        if($headerValueArray == 'application/json'){
            $response = new \Slim\Psr7\Response();
            $response = $handler->handle($request);
            return $response;
        }else{
            $data = array('code' => 406, 'message' => 'Invalid resource', 'description' => 'The application could not accept the parameter as it is invalid');
            $payload = json_encode($data);
            throw new HttpNotAcceptableException($request,$payload);
        }
        
    }
    
}
