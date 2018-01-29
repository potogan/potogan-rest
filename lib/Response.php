<?php

namespace Potogan\REST;

use Psr\Http\Message\RequestInterface as HttpRequest;
use Psr\Http\Message\ResponseInterface as HttpResponse;

/**
 * REST Response.
 */
class Response
{
    /**
     * REST Request.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * HTTP Request.
     *
     * @var HttpRequest
     */
    protected $httpRequest;

    /**
     * HTTP Response.
     *
     * @var HttpResponse
     */
    protected $httpResponse;

    /**
     * Parsed response body.
     *
     * @var mixed
     */
    protected $body;

    /**
     * Class constructor.
     *
     * @param RequestInterface $request     REST Request.
     * @param HttpRequest      $httpRequest HTTP Request.
     * @param HttpResponse     $response    HTTP Response.
     */
    public function __construct(RequestInterface $request, HttpRequest $httpRequest, HttpResponse $httpResponse)
    {
        $this->request      = $request;
        $this->httpRequest  = $httpRequest;
        $this->httpResponse = $httpResponse;
    }

    /**
     * Gets the REST Request.
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Gets the HTTP Request.
     *
     * @return HttpRequest
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * Gets the HTTP Response.
     *
     * @return HttpResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Returns an instance with the given body.
     *
     * @param string $body
     *
     * @return static
     */
    public function withBody($body)
    {
        $res = clone $this;

        $res->body = $body;

        return $res;
    }

    /**
     * Gets the Parsed response body.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
}
