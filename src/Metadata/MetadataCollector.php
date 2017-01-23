<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata;

use Asapo\Bundle\ElasticsearchBundle\Metadata\Converter\ClassMetadataConverter;
use Metadata\MetadataFactoryInterface;

class MetadataCollector
{
    /**
     * @var array
     */
    private $mapping;

    /**
     * @var ClassMetadataConverter
     */
    private $converter;

    /**
     * @var MetadataFactoryInterface
     */
    private $factory;

    /**
     * @param array $mapping
     * @param ClassMetadataConverter $converter
     * @param MetadataFactoryInterface $factory
     */
    public function __construct(array $mapping, ClassMetadataConverter $converter, MetadataFactoryInterface $factory)
    {
        $this->mapping = $mapping;
        $this->converter = $converter;
        $this->factory = $factory;
    }

    /**
     * @param $className
     *
     * @return ClassMetadata
     */
    public function create($className)
    {
        $baseMetadata = $this->factory->getMetadataForClass($className);
        if (!array_key_exists($className, $this->mapping)) {
            return $baseMetadata;
        }

        return $this->converter->convert($className, $this->mapping[$className])->merge($baseMetadata);
    }
}
