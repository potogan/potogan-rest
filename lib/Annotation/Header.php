<?php

namespace Potogan\REST\Annotation;

use Potogan\REST\AnnotationInterface;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *    @Attribute("name", required = true, type = "string"),
 *    @Attribute("value", required = true, type = "string")
 * })
 */
class Header extends Annotation implements AnnotationInterface
{
    /**
     * HTTP Header name.
     *
     * @var string
     */
    public $name;
}
