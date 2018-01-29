<?php

namespace Potogan\REST\RequestHandler;

use Potogan\REST\Response;
use Http\Client\HttpClient as HttpClientInterface;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Potogan\REST\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * HTTP Client RequestHandler, meant to be the end of the RequestHandler chain and to perform the
 *     request.
 */
class HttpClient implements RequestHandlerInterface
{
    /**
     * HTTP Client.
     *
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Class constructor.
     *
     * @param HttpClientInterface $client HTTP Client.
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        return new Response($request, $httpRequest, $this->client->sendRequest($httpRequest));
    }
}
