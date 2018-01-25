<?php

namespace Potogan\REST\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *    @Attribute("value", required = true, type = "string")
 * })
 */
class BaseUri extends AbstractUriAnnotation
{

}
