<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Potogan\REST\Http\UriMerger;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Potogan\REST\Request\AwareRequestInterface;

class AwareRequest implements MiddlewareInterface
{
    /**
     * Uri Merger
     *
     * @var UriMerger
     */
    protected $merger;

    /**
     * Class constructor.
     *
     * @param UriMerger $merger Uri merger.
     */
    public function __construct(UriMerger $merger)
    {
        $this->merger = $merger;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        if (!$request instanceof AwareRequestInterface) {
            return $httpRequest;
        }

        $httpRequest = $httpRequest
            ->withMethod($request->getMethod())
            ->withUri($this->merger->merge($httpRequest->getUri(), $request->getUri()))
        ;

        foreach ($request->getHeaders() as $key => $value) {
            $httpRequest = $httpRequest->withHeader($key, $value);
        }

        return $httpRequest;
    }
}
