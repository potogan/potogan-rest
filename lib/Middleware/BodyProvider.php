<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\ClientInterface;
use Potogan\REST\MiddlewareInterface;
use Potogan\REST\BodyProviderInterface;
use Potogan\REST\TransformerInterface;
use Potogan\REST\RequestInterface;
use Potogan\REST\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

/**
 * Middleware setting request body by calling a BodyProvider then transformers
 */
class BodyProvider implements MiddlewareInterface
{
    /**
     * @var BodyProviderInterface
     */
    protected $provider;

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * Class constructor.
     *
     * @param BodyProviderInterface $provider
     * @param TransformerInterface  $transformer
     */
    public function __construct(BodyProviderInterface $provider, TransformerInterface $transformer)
    {
        $this->provider = $provider;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritDoc}
     */
    public function process(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest, RequestHandlerInterface $handler)
    {
        $body = $this->provider->provide($request, $httpRequest, $httpRequest->getBody());

        if ($this->transformer->supports($httpRequest)) {
            $body = $this->transformer->serialize($httpRequest, $body);
        }

        $httpRequest = $httpRequest
            ->withBody($body)
        ;

        $response = $handler->handle($client, $request, $httpRequest);

        $body = null;
        if ($this->transformer->supports($response->getHttpResponse())) {
            $body = $this->transformer->unserialize(
                $response->getHttpResponse(),
                $response->getHttpResponse()->getBody()
            );
        }

        return $response->withBody($body);
    }
}
