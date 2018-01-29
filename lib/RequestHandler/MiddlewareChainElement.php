<?php

namespace Potogan\REST\RequestHandler;

use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Potogan\REST\MiddlewareInterface;
use Potogan\REST\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * Middleware wrapper chain element.
 */
class MiddlewareChainElement implements RequestHandlerInterface
{
    /**
     * Wrapped middleware.
     *
     * @var MiddlewareInterface
     */
    protected $middleware;
    
    /**
     * Next handler in the chain.
     *
     * @var RequestHandlerInterface
     */
    protected $next;

    /**
     * Class constructor.
     *
     * @param MiddlewareInterface     $middleware Wrapped middleware.
     * @param RequestHandlerInterface $next       Next handler in the chain.
     */
    public function __construct(MiddlewareInterface $middleware, RequestHandlerInterface $next)
    {
        $this->middleware = $middleware;
        $this->next = $next;
    }

    /**
     * @inheritDoc
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->middleware->process($client, $request, $httpRequest, $this->next);
    }
}
