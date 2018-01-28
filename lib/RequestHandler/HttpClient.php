<?php

namespace Potogan\REST\RequestHandler;

use Potogan\REST\Response;
use Http\Client\HttpAsyncClient;
use Psr\Http\Message\MiddlewareInterface;
use Psr\Http\Message\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Psr\Http\Message\ResponseInterface as HttpResponse;
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
     * @param HttpAsyncClient         $client HTTP Client.
     * @param RequestHandlerInterface $first  First handler in the chain.
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
        return $this->client
            ->sendAsyncRequest($httpRequest)
            ->then(function (HttpResponse $response) use ($request, $httpRequest) {
                return new Response($request, $httpRequest, $response);
            })
        ;
    }

    /**
     * @inheritDoc
     */
    public function first(RequestInterface $request, HttpRequest $httpRequest)
    {
        return $this->first->handle($request, $httpRequest);
    }
}
