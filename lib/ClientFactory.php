<?php

namespace Potogan\REST;

use Http\Message\RequestFactory;
use Http\Client\HttpClient;

class ClientFactory
{
    /**
     * Request factory.
     *
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * HTTP Client
     * 
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Middlewares
     * 
     * @var array<MiddlewareInterface>
     */
    protected $middlewares = array();

    /**
     * Class constructor.
     * 
     * @param string               $baseUrl        Rest service base url.
     * @param array                $defaultHeaders Default HTTP request headers.
     * @param RequestFactory       $requestFactory
     * @param TransformerInterface $transformer
     * @param HttpClient           $httpClient
     */
    public function __construct(RequestFactory $requestFactory, TransformerInterface $transformer, HttpClient $httpClient)
    {
        $this->requestFactory = $requestFactory;
        $this->transformer    = $transformer;
        $this->httpClient     = $httpClient;
    }

    /**
     * Adds a middleware.
     * 
     * @param MiddlewareInterface $middleware
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Builds a Client instance.
     *
     * @param string $baseUrl
     * @param array  $defaultHeaders
     *
     * @return ClientInterface
     */
    public function build($baseUrl, array $defaultHeaders = array())
    {
        $client = new Client($baseUrl, $defaultHeaders, $this->requestFactory, $this->transformer, $this->httpClient);

        foreach ($this->middlewares as $middleware) {
            $client->addMiddleware($middleware);
        }

        return $client;
    }
}
