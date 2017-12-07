<?php

namespace Potogan\REST;

use Psr\Http\Message\MessageInterface;

interface TransformerInterface
{
    public function supports(MessageInterface $message);

    public function serialize(MessageInterface $message, $body);
    
    public function unserialize(MessageInterface $message, $body);
}
