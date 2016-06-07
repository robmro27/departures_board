<?php

namespace DeparturesBoardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBusstopsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('import:busstops')->setDescription('Import Busstops');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('departures_board.importer');
        /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
        $importer->importBusstops();
        $output->writeln("Busstops was imported");
    }
}