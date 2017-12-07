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
    protected $response;

    /**
     * Parsed response body.
     *
     * @var mixed
     */
    protected $parsedBody;

    /**
     * Class constructor.
     *
     * @param RequestInterface $request     REST Request.
     * @param HttpRequest      $httpRequest HTTP Request.
     * @param HttpResponse     $response    HTTP Response.
     * @param mixed            $parsedBody  Parsed response body.
     */
    public function __construct(RequestInterface $request, HttpRequest $httpRequest, HttpResponse $response, $parsedBody)
    {
        $this->request     = $request;
        $this->httpRequest = $httpRequest;
        $this->response    = $response;
        $this->parsedBody  = $parsedBody;
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
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Gets the Parsed response body.
     *
     * @return mixed
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }
}
