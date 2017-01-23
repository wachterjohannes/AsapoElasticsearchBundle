<?php

namespace AppBundle\Document;

use Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation\Property;
use Asapo\Bundle\ElasticsearchBundle\Metadata\Annotation\Type;

/**
 * @Type("test")
 */
class TestDocument
{
    /**
     * @var string
     *
     * @Property(type="string", analyzer="german")
     */
    public $title;

    /**
     * @var string
     *
     * @Property(type="string")
     */
    public $description;
}
