<?php

namespace Potogan\REST;

use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * REST Client middlewares are meant to build/update the HTTP request based on the REST requets,
 *     before the HttpRequest is sent throught a Http client.
 *
 * Inspired from PSR 15
 */
interface MiddlewareInterface
{
    /**
     * Processes a REST Request.
     *
     * @param RequestInterface        $request     REST request.
     * @param HttpRequest             $httpRequest HTTP Request created by previous middlewares.
     * @param RequestHandlerInterface $handler     REST Request handler.
     *
     * @return Promise<Response>
     */
    public function process(RequestInterface $request, HttpRequest $httpRequest, RequestHandlerInterface $handler);
}
