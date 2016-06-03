<?php

namespace DeparturesBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use DeparturesBoardBundle\Entity\Busstop;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class BusstopController extends Controller
{


   


    public function importAction()
    {
        
        $importer = $this->get('departures_board.importer');
        /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
        
        $importer->importBusstops();
        
        return new \Symfony\Component\HttpFoundation\Response('null');
        
    }
    

    public function importBusstopAction()
    {
        
       $importer = $this->get('departures_board.importer');
       /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
        
       $importer->importDeparturesForBusstop('0004');
        
       return new \Symfony\Component\HttpFoundation\Response('null');
        
    }
    
    
    
    
    
    
}
