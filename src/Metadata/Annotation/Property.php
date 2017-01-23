<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Property
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $analyzer;

    public function __construct(array $values)
    {
        $optionResolver = new OptionsResolver();
        $optionResolver->setDefault('analyzer', 'default');
        $optionResolver->setRequired(['type']);
        $optionResolver->setAllowedTypes('type', 'string');
        $optionResolver->setAllowedTypes('analyzer', 'string');

        $values = $optionResolver->resolve($values);

        $this->type = $values['type'];
        $this->analyzer = $values['analyzer'];
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

    /**
     * Returns analyzer.
     *
     * @return string
     */
    public function getAnalyzer()
    {
        return $this->analyzer;
    }
}
