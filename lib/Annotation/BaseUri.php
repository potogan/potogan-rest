<?php

namespace Potogan\REST\Annotation;

use Potogan\REST\AnnotationInterface;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *    @Attribute("value", required = true, type = "string")
 * })
 */
class BaseUri extends Annotation implements AnnotationInterface
{

}
