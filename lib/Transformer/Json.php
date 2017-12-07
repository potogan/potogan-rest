<?php

namespace Potogan\REST\Transformer;

use Potogan\REST\TransformerInterface;
use Psr\Http\Message\MessageInterface;

class Json implements TransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(MessageInterface $message)
    {
        return $message->getHeaderLine('Content-Type') === 'application/json';
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(MessageInterface $message, $body)
    {
        return json_encode($body);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize(MessageInterface $message, $body)
    {
        return json_decode($body, true);
    }
}
