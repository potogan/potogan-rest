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
     * @param RequestInterface $request     REST Request.
     * @param HttpRequest      $httpRequest HTTP Request.
     *
     * @return Promise<Response>
     */
    public function handle(RequestInterface $request, HttpRequest $httpRequest);

    /**
     * Handles the Request by restarting the whole RequestHandler stack (usefull to send a new 
     *     Request during the processing of a Request)
     *
     * @param RequestInterface $request     REST Request.
     * @param HttpRequest      $httpRequest HTTP Request.
     *
     * @return Promise<Response>
     */
    public function first(RequestInterface $request, HttpRequest $httpRequest);
}
