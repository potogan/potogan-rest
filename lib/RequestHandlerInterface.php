<?php

namespace Potogan\REST;

use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * A REST request handler process a REST request and produces a REST response.
 *
 * Inspired by PSR 15 & Psr\Http\Server\RequestHandlerInterface.
 */
interface RequestHandlerInterface
{
    /**
     * Handles the Request then return a promise of Response
     *
     * @param ClientInterface  $client      REST Client.
     * @param RequestInterface $request     REST Request.
     * @param HttpRequest      $httpRequest HTTP Request.
     *
     * @return Response
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest);
}
