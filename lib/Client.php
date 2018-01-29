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
     * REST Request handler
     * 
     * @var RequestHandlerInterface
     */
    protected $handler;

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
     * Class constructor.
     * 
     * @param RequestFactory          $requestFactory HTTP Request factory.
     * @param RequestHandlerInterface $handler        REST Request handler (basically a middleware chain ending on an HTTP Client) 
     * @param string                  $baseUrl        Rest service base url.
     * @param array                   $defaultHeaders Default HTTP request headers.
     */
    public function __construct(RequestFactory $requestFactory, RequestHandlerInterface $handler, $baseUrl = null, array $defaultHeaders = array())
    {
        $this->baseUrl        = $baseUrl;
        $this->defaultHeaders = $defaultHeaders;
        $this->requestFactory = $requestFactory;
        $this->handler        = $handler;
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

        return $this->handler->handle($this, $request, $httpRequest);
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
