<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation\Property;
use Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation\Type;
use Asapo\Bundle\ElasticsearchBundle\Metadata\ClassMetadata;
use Asapo\Bundle\ElasticsearchBundle\Metadata\PropertyMetadata;
use Metadata\Driver\DriverInterface;

class AnnotationDriver implements DriverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new ClassMetadata($class->name);
        $classMetadata->fileResources[] = $class->getFilename();

        foreach ($this->reader->getClassAnnotations($class) as $annotation) {
            if ($annotation instanceof Type) {
                $classMetadata->type = $annotation->getType();
            }
        }

        foreach($class->getProperties() as $property) {
            $propertyMetadata = new PropertyMetadata($class->getName(), $property->getName());
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof Property) {
                    $propertyMetadata->type = $annotation->getType();
                    $propertyMetadata->analyzer = $annotation->getAnalyzer();
                }
            }

            $classMetadata->addPropertyMetadata($propertyMetadata);
        }

        return $classMetadata;
    }
}
