<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata\Driver;

use Asapo\Bundle\ElasticsearchBundle\Metadata\Converter\ClassMetadataConverter;
use Metadata\Driver\AbstractFileDriver;
use Metadata\Driver\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;

class YamlDriver extends AbstractFileDriver
{
    /**
     * @var ClassMetadataConverter
     */
    private $converter;

    public function __construct(FileLocatorInterface $locator, ClassMetadataConverter $converter)
    {
        parent::__construct($locator);

        $this->converter = $converter;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadMetadataFromFile(\ReflectionClass $class, $file)
    {
        $config = Yaml::parse(file_get_contents($file));
        if (!isset($config[$name = $class->name])) {
            throw new \RuntimeException(
                sprintf('Expected metadata for class %s to be defined in %s.', $class->name, $file)
            );
        }

        return $this->converter->convert($class->getName(), $config[$class->getName()], [$class->getFileName(), $file]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtension()
    {
        return 'yml';
    }
}
