<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Potogan\REST\Http\UriMerger;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Potogan\REST\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

class RequestClassMapUri implements MiddlewareInterface
{
    /**
     * Uri Merger
     *
     * @var UriMerger
     */
    protected $merger;

    /**
     * Class to Url map.
     *
     * @var array
     */
    protected $map;

    /**
     * Class constructor.
     *
     * @param UriMerger $merger Uri merger.
     * @param iterable  $map    Url map.
     */
    public function __construct(UriMerger $merger, $map = array())
    {
        $this->merger = $merger;
        $this->map    = $map;
    }

    /**
     * Adds an url to the map.
     *
     * @param string $class Class/Interface to map with url.
     * @param string $url   Url.
     */
    public function addUrl($class, $url)
    {
        $this->map[$class] = $url;
    }

    /**
     * {@inheritDoc}
     */
    public function process(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest, RequestHandlerInterface $handler)
    {
        foreach ($this->map as $class => $uri) {
            if (!$request instanceof $class) {
                continue;
            }

            $httpRequest = $httpRequest->withUri($this->merger->merge(
                $httpRequest->getUri(),
                $uri
            ));
        }

        return $handler->handle($client, $request, $httpRequest);
    }
}
