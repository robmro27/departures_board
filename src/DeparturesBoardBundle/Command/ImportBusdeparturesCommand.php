<?php

namespace DeparturesBoardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBusdeparturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('import:busdepartures')
                ->setDescription('Import Busstop departures')
                ->addArgument('busstopCode',InputArgument::REQUIRED,'Code of busstop');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $busstopCode = $input->getArgument('busstopCode');
        
        $importer = $this->getContainer()->get('departures_board.importer');
        /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
        $importer->importDeparturesForBusstop($busstopCode);
        $output->writeln("Busstop departures was imported");
    }
}