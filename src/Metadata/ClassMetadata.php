<?php

namespace Asapo\Bundle\ElasticsearchBundle\Metadata;

use Metadata\MergeableClassMetadata as BaseClassMetadata;
use Metadata\MergeableInterface;

class ClassMetadata extends BaseClassMetadata
{
    /**
     * @var string
     */
    public $type;

    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof self) {
            throw new \InvalidArgumentException('$object must be an instance of MergeableClassMetadata.');
        }

        $this->name = $object->name;
        $this->type = $object->type;
        $this->reflection = $object->reflection;
        $this->fileResources = array_merge($this->fileResources, $object->fileResources);

        foreach ($this->propertyMetadata as $name => $metadata) {
            if (!array_key_exists($name, $object->propertyMetadata)) {
                continue;
            }

            $metadata->merge($object->propertyMetadata[$name]);
            unset($object->propertyMetadata[$name]);
        }
        $this->propertyMetadata = array_merge($this->propertyMetadata, $object->propertyMetadata);

        // TODO merge method metadata - if needded
        $this->methodMetadata = array_merge($this->methodMetadata, $object->methodMetadata);

        if ($object->createdAt < $this->createdAt) {
            $this->createdAt = $object->createdAt;
        }

        return $this;
    }

    public function toArray()
    {
        $params = [
            'properties' => [],
        ];

        foreach ($this->propertyMetadata as $property) {
            $params['properties'][$property->name] = ['type' => $property->type, 'analyzer' => $property->analyzer];
        }

        return $params;
    }
}
