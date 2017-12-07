<?php

namespace Potogan\REST\BodyProvider;

use Potogan\REST\BodyProviderInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Potogan\REST\Request\AwareRequestInterface;

class AwareRequest implements BodyProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function provide(RequestInterface $request, HttpRequest $httpRequest, $body)
    {
        if (!$request instanceof AwareRequestInterface) {
            return $body;
        }

        return $request->getBody();
    }
}
