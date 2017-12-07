<?php

namespace Potogan\REST;

/**
 * REST client interface.
 */
interface ClientInterface
{
    /**
     * Sends a request, and returns parsed result.
     *
     * @param RequestInterface $request
     * 
     * @return mixed
     */
    public function send(RequestInterface $request);

    /**
     * Gets attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Get an attribute.
     *
     * @param string $name    Attribute name.
     * @param mixed  $default Fallback value
     * 
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * Checks if attribute exists.
     *
     * @param string $name Attribute name.
     * 
     * @return boolean
     */
    public function hasAttribute($name);

    /**
     * Set an attribute.
     * 
     * @param string $name  Attribute name.
     * @param mixed  $value Attribute value.
     *
     * @return self
     */
    public function setAttribute($name, $value);

    /**
     * Removes an attribute.
     * 
     * @param string $name Attribute name.
     * 
     * @return self
     */
    public function removeAttribute($name);
}
