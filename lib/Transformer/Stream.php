<?php

namespace Potogan\REST\Transformer;

use Potogan\REST\TransformerInterface;
use Http\Message\StreamFactory;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * String / StreamInterface transformer
 */
class Stream implements TransformerInterface
{
    /**
     * @var StreamFactory
     */
    protected $streamFactory;

    /**
     * Class constructor.
     *
     * @param StreamFactory $streamFactory
     */
    public function __construct(StreamFactory $streamFactory)
    {
        $this->streamFactory = $streamFactory;
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
        if (!$body instanceof StreamInterface) {
            return $this->streamFactory->createStream($body);
        }
        return $body;
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize(MessageInterface $message, $body)
    {

        if ($body instanceof StreamInterface) {
            return $this->streamFactory->createStream($body);
        }
        return (string)$body;
    }
}
