<?php

namespace Potogan\REST\Request;

use Potogan\REST\RequestInterface;

interface BodyAwareRequestInterface extends RequestInterface
{
    /**
     * Gets the http body for this request.
     * 
     * @return mixed
     */
    public function getBody();
}
