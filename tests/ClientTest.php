<?php

namespace Potogan\REST\Tests;

use PHPUnit_Framework_TestCase;
use Potogan\REST\Client;
use Potogan\REST\Response;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Client(
            $this->requestFactory = $this->createMock('Http\Message\RequestFactory'),
            $this->requestHandler = $this->createMock('Potogan\REST\RequestHandlerInterface'),
            $this->baseUrl = 'test base url',
            $this->defaultHeaders = [
                'X-Powered-By' => 'Intravenous Caffeine Drips',
            ]
        );
    }

    public function testSend()
    {
        $request = $this->createMock('Potogan\REST\RequestInterface');

        $response = new Response(
            $request,
            $httpRequest = $this->createMock('Psr\Http\Message\RequestInterface'),
            $this->createMock('Psr\Http\Message\ResponseInterface'),
            true
        );

        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', $this->baseUrl, $this->defaultHeaders, null, '1.1')
            ->will($this->returnValue($httpRequest))
        ;

        $this->requestHandler
            ->expects($this->once())
            ->method('handle')
            ->with($this->client, $request, $httpRequest)
            ->will($this->returnValue($response))
        ;

        $this->assertSame($response, $this->client->send($request));
    }

    public function testSetGetAttribute()
    {
        // Attribute does  not exists
        $this->assertFalse($this->client->hasAttribute('test'));
        $this->assertSame(42, $this->client->getAttribute('test', 42));

        // Set attribute
        $this->assertSame($this->client, $this->client->setAttribute('test', 2326));
        $this->assertTrue($this->client->hasAttribute('test'));
        $this->assertSame(2326, $this->client->getAttribute('test', 42));
    }
}