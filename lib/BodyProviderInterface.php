<?php

namespace Potogan\REST;

use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * Builds the http request content
 */
interface BodyProviderInterface
{
    /**
     * Extracts/Generates request content from request.
     *
     * @param  RequestInterface $request
     * @param  HttpRequest      $httpRequest
     * @param  mixed            $body        Previously generated content.
     *
     * @return mixed Any form of content.
     */
    public function provide(RequestInterface $request, HttpRequest $httpRequest, $body);
}
