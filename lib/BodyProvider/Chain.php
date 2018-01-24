<?php

namespace Potogan\REST\BodyProvider;

use Potogan\REST\BodyProviderInterface;
use Potogan\REST\RequestInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;

class Chain implements BodyProviderInterface
{
    /**
     * Provider chain.
     *
     * @var array<BodyProviderInterface>
     */
    protected $providers = array();

    /**
     * Adds a bunch of providers to the chain.
     *
     * @param iterable<BodyProviderInterface> $providers
     */
    public function addProviders($providers)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }

        return $this;
    }

    /**
     * Adds a provider to the chain.
     *
     * @param BodyProviderInterface $provider
     */
    public function addProvider(BodyProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function provide(RequestInterface $request, HttpRequest $httpRequest, $body)
    {
        foreach ($this->providers as $provider) {
            $body = $provider->provide($request, $httpRequest, $body);
        }

        return $body;
    }
}
