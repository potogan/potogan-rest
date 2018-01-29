<?php

namespace Potogan\REST;

use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * REST Client middlewares are meant to build/update the HTTP request based on the REST requets,
 *     before the HttpRequest is sent throught a Http client.
 *
 * Inspired from PSR 15 & php-http/client-common
 * The client is transmitted as a parameter to mimic the fature provided by the $first callable
 *     in client-common plugin stack. It could have been accessible throught the
 *     RequestHandlerInterface, but doing so reduces the dependency spaghetti.
 */
interface MiddlewareInterface
{
    /**
     * Processes a REST Request.
     *
     * @param ClientInterface         $client      REST Client.
     * @param RequestInterface        $request     REST request.
     * @param HttpRequest             $httpRequest HTTP Request created by previous middlewares.
     * @param RequestHandlerInterface $handler     REST Request handler.
     *
     * @return Response
     */
    public function process(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest, RequestHandlerInterface $handler);
}
