<?php

namespace Potogan\REST\RequestHandler;

use Http\Client\HttpAsyncClient;
use Psr\Http\Message\MiddlewareInterface;
use Psr\Http\Message\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * HTTP CLient RequestHandler, meant to be the end of the RequestHandler chain and to perform the
 *     request.
 */
class HttpClient implements RequestHandlerInterface
{
    /**
     * HTTP Client.
     *
     * @var HttpAsyncClient
     */
    protected $client;

    /**
     * First frame.
     *
     * @var RequestHandlerInterface
     */
    protected $first;

    /**
     * Class constructor.
     *
     * @param HttpAsyncClient $client HTTP Client.
     */
    public function __construct(HttpAsyncClient $client, RequestHandlerInterface $first)
    {
        $this->client = $client;
        $this->first = $first;
    }

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->client->sendAsyncRequest($httpRequest);
    }

    /**
     * @inheritDoc
     */
    public function first(RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->first->handle($request, $httpRequest);
    }
}
