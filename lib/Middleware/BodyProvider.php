<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Potogan\REST\BodyProviderInterface;
use Potogan\REST\TransformerInterface;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
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
     * @param StreamFactory         $streamFactory
     */
    public function __construct(BodyProviderInterface $provider, TransformerInterface $transformer)
    {
        $this->provider = $provider;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ClientInterface $client, RequestInterface $request, HttpRequest $httpRequest)
    {
        $body = $this->provider->provide($request, $httpRequest, $httpRequest->getBody());

        if ($this->transformer->supports($httpRequest)) {
            $body = $this->transformer->serialize($httpRequest, $body);
        }

        return $httpRequest
            ->withBody($body)
        ;
    }
}
