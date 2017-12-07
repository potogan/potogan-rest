<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Potogan\REST\Request\AwareRequestInterface;

class AwareRequest implements MiddlewareInterface
{
    /**
     * {@inheritDoc}
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        if (!$request instanceof AwareRequestInterface) {
            return $httpRequest;
        }

        // Basic relative url resolving.
        $uri = $httpRequest->getUri();
        $parts = parse_url((string)$request->getUri());

        if (isset($parts['host'])) {
            $uri = $request->getUri();
        } elseif (isset($parts['path'])) {
            if (substr($parts['path'], 0, 1) === '/') {
                $uri->withPath($parts['path']);
            } else {
                $uri->withPath($uri->getPath() . $parts['path']);
            }

            $uri
                ->withQuery(isset($parts['query']) ? $parts['query'] : null)
                ->withFragment(isset($parts['fragment']) ? $parts['fragment'] : null)
            ;
        }

        $httpRequest = $httpRequest
            ->withMethod($request->getMethod())
            ->withUri($uri)
        ;

        foreach ($request->getHeaders() as $key => $value) {
            $httpRequest = $httpRequest->withHeader($key, $value);
        }

        return $httpRequest;
    }
}
