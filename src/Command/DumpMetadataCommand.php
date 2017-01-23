<?php

namespace Asapo\Bundle\ElasticsearchBundle\Command;

use Asapo\Bundle\ElasticsearchBundle\Metadata\MetadataCollector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpMetadataCommand extends Command
{
    const CLASS_NAME_ARGUMENT = 'className';

    /**
     * @var MetadataCollector
     */
    private $metadataCollector;

    /**
     * @param string $name
     * @param MetadataCollector $metadataCollector
     */
    public function __construct($name, MetadataCollector $metadataCollector)
    {
        parent::__construct($name);

        $this->metadataCollector = $metadataCollector;
    }


    protected function configure()
    {
        $this->addArgument(self::CLASS_NAME_ARGUMENT);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $metadata = $this->metadataCollector->create($input->getArgument(self::CLASS_NAME_ARGUMENT));

        $output->writeln('Type: ' . $metadata->type);
        $output->writeln('Properties: ');
        foreach ($metadata->propertyMetadata as $propertyName => $propertyMetadata) {
            $output->writeln('  ' . $propertyName . ':');
            $output->writeln('    Type: '.$propertyMetadata->type);
            $output->writeln('    Analyzer: '.$propertyMetadata->analyzer);
        }
    }
}
