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

        if (isset($parts['scheme'])) {
            $uri = $uri->withScheme($parts['scheme']);
        }

        if (isset($parts['user'])) {
            $uri = $uri->withUserInfo(
                $parts['user'],
                isset($parts['pass']) ? $parts['pass'] : null
            );
        }

        if (isset($parts['host'])) {
            $uri = $uri
                ->withHost($parts['host'])
                ->withPort(isset($parts['port']) ? $parts['port'] : null)
            ;
        }

        if (isset($parts['path'])) {
            if (substr($parts['path'], 0, 1) === '/') {
                $uri = $uri->withPath($parts['path']);
            } else {
                $uri = $uri->withPath($uri->getPath() . $parts['path']);
            }
        }

        $uri = $uri
            ->withQuery(isset($parts['query']) ? $parts['query'] : '')
            ->withFragment(isset($parts['fragment']) ? $parts['fragment'] : '')
        ;

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
