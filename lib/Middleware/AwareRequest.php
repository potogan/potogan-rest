<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Http\Message\RequestFactory;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Potogan\REST\Request\AwareRequestInterface;

class AwareRequest implements MiddlewareInterface
{
    /**
     * Request factory.
     *
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * Class constructor.
     *
     * @param RequestFactory $requestFactory
     */
    public function __construct(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        if (!$request instanceof AwareRequestInterface) {
            return $httpRequest;
        }

        foreach ($request->getHeaders() as $key => $value) {
            $httpRequest = $httpRequest->withHeader($key, $value);
        }

        return $this->requestFactory->createRequest(
            $request->getMethod(),
            $request->getUri(),
            $httpRequest->getHeaders(),
            $httpRequest->getBody(),
            $httpRequest->getProtocolVersion()
        );
    }
}
