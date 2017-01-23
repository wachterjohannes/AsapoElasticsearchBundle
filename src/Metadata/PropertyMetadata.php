<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

class PropertyMetadata extends BasePropertyMetadata
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $analyzer;

    public function merge(PropertyMetadata $metadata)
    {
        $this->type = $metadata->type;
        $this->analyzer = $metadata->analyzer;
    }
}
