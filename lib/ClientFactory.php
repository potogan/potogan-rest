<?php

namespace Potogan\REST;

use Http\Message\RequestFactory;
use Http\Client\HttpAsyncClient;
use Potogan\REST\RequestHandlerInterface;
use Potogan\REST\RequestHandler\ChainFirstElement;
use Potogan\REST\RequestHandler\HttpClient as HttpClientRequestHandler;
use Potogan\REST\RequestHandler\MiddlewareChainElement;

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
     * @var HttpAsyncClient
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
     * @param HttpAsyncClient           $httpClient
     */
    public function __construct(RequestFactory $requestFactory, TransformerInterface $transformer, HttpAsyncClient $httpClient)
    {
        $this->requestFactory = $requestFactory;
        $this->transformer    = $transformer;
        $this->httpClient     = $httpClient;
    }

    /**
     * Adds multiple middlewares.
     *
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function addMiddlewares($middlewares)
    {
        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }
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
    public function build($baseUrl = null, array $defaultHeaders = array())
    {
        $client = new Client($baseUrl, $defaultHeaders, $this->requestFactory, $this->transformer, $this->httpClient);

        $client->addMiddlewares($this->middlewares);

        return $client;
    }

    /**
     * Builds the client's middleware stack.
     *
     * @return RequestHandlerInterface
     */
    public function buildMiddlewareStack()
    {
        $first = new ChainFirstElement();
        $next = new HttpClientRequestHandler($this->client);

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = new MiddlewareChainElement($middleware, $first, $next);
        }

        $first->setNext($next);

        return $first;
    }
}
