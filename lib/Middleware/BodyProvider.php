<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Potogan\REST\BodyProviderInterface;
use Potogan\REST\TransformerInterface;
use Http\Message\StreamFactory;
use Potogan\REST\ClientInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use Psr\Http\Message\StreamInterface;

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
     * @var StreamFactory
     */
    protected $streamFactory;

    /**
     * Class constructor.
     *
     * @param BodyProviderInterface $provider
     * @param TransformerInterface  $transformer
     * @param StreamFactory         $streamFactory
     */
    public function __construct(BodyProviderInterface $provider, TransformerInterface $transformer, StreamFactory $streamFactory)
    {
        $this->provider = $provider;
        $this->transformer = $transformer;
        $this->streamFactory = $streamFactory;
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
        
        if (!$body instanceof StreamFactory) {
            $body = $this->streamFactory->createStream($body);
        }

        return $httpRequest
            ->withBody($body)
        ;
    }
}
