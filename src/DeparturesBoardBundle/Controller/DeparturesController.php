<?php

namespace DeparturesBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DeparturesController extends Controller
{

    public function showAction()
    {
        
//        $importer = $this->get('departures_board.importer');
//        /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
//        $importer->importDeparturesForBusstop('0022');
////      $importer->importBusstops();
        
        return $this->render('DeparturesBoardBundle:Departure:show.html.twig',[]);
    }
    
}
