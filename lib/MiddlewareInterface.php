<?php

namespace Potogan\REST;

use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * REST Client middlewares are meant to build/update the HTTP request based on the REST requets,
 *     before the HttpRequest is sent throught a Http client.
 */
interface MiddlewareInterface
{
    /**
     * Handles HttpRequest.
     *
     * @param ClientInterface  $client      REST client.
     * @param RequestInterface $request     REST request.
     * @param HttpRequest      $httpRequest HTTP Request created by previous middlewares.
     *
     * @return HttpRequest
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest);
}
