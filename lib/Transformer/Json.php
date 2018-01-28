<?php

namespace Potogan\REST\Transformer;

use Potogan\REST\TransformerInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Json implements TransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(MessageInterface $message)
    {
        return preg_match('/^application\\/json($|;)/', $message->getHeaderLine('Content-Type'));
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(MessageInterface $message, $body)
    {
        if ($body instanceof StreamInterface) {
            return $body;
        }

        return json_encode($body);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize(MessageInterface $message, $body)
    {
        if (!is_string($body)) {
            return $body;
        }

        return json_decode($body, true);
    }
}
