<?php

namespace Potogan\REST\Request;

use Psr\Http\Message\UriInterface;

interface AwareRequestInterface extends BodyAwareRequestInterface
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
}
