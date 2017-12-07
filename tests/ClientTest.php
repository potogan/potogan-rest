<?php

namespace Potogan\REST\Tests;

use PHPUnit_Framework_TestCase;
use Potogan\REST\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetAttribute()
    {
        $client = new Client('');

        // Attribute does  not exists
        $this->assertFalse($client->hasAttribute('test'));
        $this->assertSame(42, $client->getAttribute('test', 42));

        // Set attribute
        $this->assertSame($client, $client->setAttribute('test', 2326));
        $this->assertTrue($client->hasAttribute('test'));
        $this->assertSame(2326, $client->getAttribute('test', 42));
    }
}