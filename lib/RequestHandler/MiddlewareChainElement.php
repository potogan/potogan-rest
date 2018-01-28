<?php

namespace Potogan\REST\RequestHandler;

use Psr\Http\Message\MiddlewareInterface;
use Psr\Http\Message\RequestHandlerInterface;
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
     * First handler in the chain.
     *
     * @var RequestHandlerInterface
     */
    protected $first;
    
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
     * @param RequestHandlerInterface $first      First handler in the chain.
     * @param RequestHandlerInterface $next       Next handler in the chain.
     */
    public function __construct(MiddlewareInterface $middleware, RequestHandlerInterface $first, RequestHandlerInterface $next)
    {
        $this->middleware = $this->middleware;
        $this->first = $this->first;
        $this->next = $this->next;
    }

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->middleware->handle($request, $httpRequest, $this->next);
    }

    /**
     * @inheritDoc
     */
    public function first(RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->first->handle($request, $httpRequest);
    }
}
