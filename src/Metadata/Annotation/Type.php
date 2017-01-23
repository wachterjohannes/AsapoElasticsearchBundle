<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Type
{
    /**
     * @var string
     */
    private $type;

    public function __construct(array $values)
    {
        if (!is_string($values['value'])) {
            throw new \RuntimeException('"value" must be a string.');
        }

        $this->type = $values['value'];
    }

    /**
     * Returns type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
