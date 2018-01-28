<?php

namespace Potogan\REST\RequestHandler;

use RuntimeException;
use Psr\Http\Message\MiddlewareInterface;
use Psr\Http\Message\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * RequestHandlerInterface chain first element.
 *
 * Due to the way the chain is built (with each element requiring a first Handler), we need a
 *     buildable first element.
 */
class ChainFirstElement implements RequestHandlerInterface
{
    /**
     * Next handler in the chain.
     *
     * @var RequestHandlerInterface
     */
    protected $next;

    /**
     * Sets Next handler in the chain.
     *
     * @param RequestHandlerInterface $next
     */
    public function setNext(RequestHandlerInterface $next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request, HttpRequest $httpRequest)
    {
        if ($this->next === null) {
            throw new RuntimeException('Chain improperly initialized : the starting element did not receive any next element.');
        }
        return $this->next->handle($request, $httpRequest);
    }

    /**
     * @inheritDoc
     */
    public function first(RequestInterface $request, HttpRequest $httpRequest)
    {
        throw new RuntimeException('I\'m meant to be the first element !');
    }
}
