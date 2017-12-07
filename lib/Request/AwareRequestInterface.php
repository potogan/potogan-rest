<?php

namespace Potogan\REST\Request;

use Potogan\REST\RequestInterface;
use Psr\Http\Message\UriInterface;

interface AwareRequestInterface extends RequestInterface
{
    /**
     * Gets the url (or path) for this request.
     * 
     * @return string
     */
    public function getMethod();

    /**
     * Gets the url (or path) for this request.
     * 
     * @return string|UriInterface
     */
    public function getUri();

    /**
     * Get http headers for this request.
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Gets the http body for this request.
     * 
     * @return mixed
     */
    public function getBody();
}
