<?php

namespace Potogan\REST\Transformer;

use Potogan\REST\TransformerInterface;
use Psr\Http\Message\MessageInterface;

class Chain implements TransformerInterface
{
    /**
     * Transformers.
     *
     * @var array<TransformerInterface>
     */
    protected $transformers = array();

    /**
     * Atts a transformer to the chain.
     *
     * @param TransformerInterface $transformer
     */
    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(MessageInterface $message)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(MessageInterface $message, $body)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($message)) {
                $body = $transformer->serialize($message, $body);
            }
        }

        return $body;
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize(MessageInterface $message, $body)
    {
        foreach (array_reverse($this->transformers) as $transformer) {
            if ($transformer->supports($message)) {
                $body = $transformer->unserialize($message, $body);
            }
        }

        return $body;
    }
}
