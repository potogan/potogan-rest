<?php

namespace Potogan\REST\Middleware;

use Potogan\REST\MiddlewareInterface;
use Doctrine\Common\Annotations\Reader;
use Potogan\REST\Http\UriMerger;
use Potogan\REST\RequestInterface;
use Potogan\REST\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface as HttpRequest;
use ReflectionClass;
use Potogan\REST\Annotation as REST;

/**
 * Reads request's annotation (with inheritance) to extract request uri, method, headers, etc...
 */
class AnnotationReader implements MiddlewareInterface
{
    /**
     * Annotation reader.
     * 
     * @var Reader
     */
    protected $reader;

    /**
     * Uri Merger
     *
     * @var UriMerger
     */
    protected $merger;

    /**
     * Class constructor.
     *
     * @param Reader    $reader Annotation reader.
     * @param UriMerger $merger Uri merger.
     */
    public function __construct(Reader $reader, UriMerger $merger)
    {
        $this->reader = $reader;
        $this->merger = $merger;
    }

    /**
     * {@inheritDoc}
     */
    public function process(RequestInterface $request, HttpRequest $httpRequest, RequestHandlerInterface $handler)
    {
        $classStack = array(new ReflectionClass($request));

        // Building inheritance stack. Parent classes have priority over interfaces.
        for ($i=0; $i < count($classStack); $i++) { 
            $class = $classStack[$i];

            if ($class->getParentClass()) {
                $classStack[] = $class->getParentClass();
            }

            // By doing this, it means that parent class have priority over interfaces, but that
            //     interface have also priority over parent' parent class. It might change.
            foreach ($class->getInterfaces() as $interface) {
                $classStack[] = $interface;
            }
        }

        $classStack = array_reverse($classStack);

        $annotations = array_map(array($this->reader, 'getClassAnnotations'), $classStack);
        $annotations = call_user_func_array('array_merge', $annotations);

        $lastBaseUri = null;
        $lastLocalUri = null;
        $lastMethod = null;
        foreach ($annotations as $annotation) {
            if ($annotation instanceof REST\BaseUri) {
                $lastBaseUri = $annotation;

                continue;
            }

            if ($annotation instanceof REST\LocalUri) {
                $lastLocalUri = $annotation;

                continue;
            }

            if ($annotation instanceof REST\Method) {
                $lastMethod = $annotation;

                continue;
            }

            if ($annotation instanceof REST\Header) {
                $httpRequest = $httpRequest->withHeader($annotation->name, $annotation->value);

                continue;
            }
        }

        if ($lastBaseUri !== null) {
            $httpRequest = $httpRequest->withUri($this->merger->merge(
                $httpRequest->getUri(),
                $lastBaseUri->getUri($request)
            ));
        }
        if ($lastLocalUri !== null) {
            $httpRequest = $httpRequest->withUri($this->merger->merge(
                $httpRequest->getUri(),
                $lastLocalUri->getUri($request)
            ));
        }
        if ($lastMethod !== null) {
            $httpRequest = $httpRequest->withMethod($lastMethod->value);
        }

        return $handler->handle($request, $httpRequest);
    }
}
