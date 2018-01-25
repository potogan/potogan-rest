<?php

namespace Potogan\REST\Annotation;

use ReflectionObject;
use Potogan\REST\RequestInterface;
use Potogan\REST\AnnotationInterface;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *    @Attribute("value", required = true, type = "string")
 * })
 */
abstract class AbstractUriAnnotation extends Annotation implements AnnotationInterface
{
    /**
     * Get the Uri described by the annotation
     *
     * @param RequestInterface $request Annotated object.
     *
     * @return string
     */
    public function getUri(RequestInterface $request)
    {
        $matches = [];
        preg_match_all('/\{([[:alnum:]]+)\}/', $this->value, $matches, PREG_SET_ORDER);

        $res = $this->value;

        foreach ($matches as $match) {
            if (null === $param = $this->extractParameterFromRequest($request, $match[1])) {
                continue;
            }

            $res = str_replace($match[0], $param, $res);
        }

        return $res;
    }

    /**
     * Extracts a named parameter from the annotated request object.
     *
     * @param RequestInterface $request Annotated request object.
     * @param string           $name    Parameter name.
     * 
     * @return string|null
     */
    protected function extractParameterFromRequest(RequestInterface $request, $name)
    {
        $refl = new ReflectionObject($request);

        if ($refl->hasProperty($name) && $refl->getProperty($name)->isPublic()) {
            return $request->$name;
        }

        $methods = [
            $name,
            'get' . ucfirst($name)
        ];

        foreach ($methods as $m) {
            if (
                $refl->hasMethod($m)
                && ($method = $refl->getMethod($m))
                && $method->isPublic()
                && !$method->getNumberOfRequiredParameters()
            ) {
                return $request->$m();
            }
        }
    }
}
