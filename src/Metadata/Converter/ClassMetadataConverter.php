<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata\Converter;

use Asapo\Bundle\ElasticsearchBundle\Metadata\ClassMetadata;
use Asapo\Bundle\ElasticsearchBundle\Metadata\PropertyMetadata;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassMetadataConverter
{
    public function convert($className, array $config, array $resources = [])
    {
        $config = $this->validateRoot($config);

        $classMetadata = new ClassMetadata($className);
        $classMetadata->fileResources = $resources;

        $classMetadata->type = $config['type'];

        foreach ($config['properties'] as $propertyName => $propertyConfig) {
            $propertyConfig = $this->validateProperty($propertyConfig);

            $propertyMetadata = new PropertyMetadata($className, $propertyName);
            $propertyMetadata->type = $propertyConfig['type'];
            $propertyMetadata->analyzer = $propertyConfig['analyzer'];

            $classMetadata->addPropertyMetadata($propertyMetadata);
        }

        return $classMetadata;
    }

    private function validateRoot(array $config)
    {
        return (new OptionsResolver())->setDefault('type', null)->setDefault('properties', [])->resolve($config);
    }

    private function validateProperty(array $config)
    {
        return (new OptionsResolver())->setRequired('type')->setDefault('analyzer', 'default')->resolve($config);
    }
}
