<?php

namespace Potogan\REST;

use Http\Message\RequestFactory;
use Http\Client\HttpClient;

class Client implements ClientInterface
{
    /**
     * Request factory.
     *
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * Middlewares
     * 
     * @var array<MiddlewareInterface>
     */
    protected $middlewares = array();

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * Rest service base url.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Request default headers.
     *
     * @var array
     */
    protected $defaultHeaders;

    /**
     * Client attributes, meant to be used by middlewares.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * HTTP Client
     * 
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Class constructor.
     * 
     * @param string               $baseUrl        Rest service base url.
     * @param array                $defaultHeaders Default HTTP request headers.
     * @param RequestFactory       $requestFactory
     * @param TransformerInterface $transformer
     * @param HttpClient           $httpClient
     */
    public function __construct($baseUrl, array $defaultHeaders = array(), RequestFactory $requestFactory, TransformerInterface $transformer, HttpClient $httpClient)
    {
        $this->baseUrl        = $baseUrl;
        $this->defaultHeaders = $defaultHeaders;
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
     * @inheritDoc
     */
    public function send(RequestInterface $request)
    {
        $httpRequest = $this->requestFactory->createRequest(
            'GET',
            $uri = $this->baseUrl,
            $headers = $this->defaultHeaders,
            $body = null,
            $protocolVersion = '1.1'
        );

        foreach ($this->middlewares as $middle) {
            $httpRequest = $middle->handle($this, $request, $httpRequest);
        }

        $response = $this->httpClient->sendRequest($httpRequest);

        $body = null;
        if ($this->transformer->supports($response)) {
            $body = $this->transformer->unserialize($response, $response->getBody());
        }

        return new Response($request, $httpRequest, $response, $body);
    }

    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function getAttribute($name, $default = null)
    {
        if ($this->hasAttribute($name)) {
            return $this->attributes[$name];
        }

        return $default;
    }

    /**
     * @inheritDoc
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * @inheritDoc
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            unset($this->attributes[$name]);
        }

        return $this;
    }
}
