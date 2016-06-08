<?php

namespace DeparturesBoardBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\Criteria;
    
class ApiController extends FOSRestController {
    
     
    public function getBusstopsAction() 
    {
        
        $repository = $this->getDoctrine()->getRepository('DeparturesBoardBundle:Busstop');
        $data = $repository->getBusstops();
        
        $view = $this->view($data, 200)->setHeader('Access-Control-Allow-Origin', '*');
        return $this->handleView($view);
        
    }
    
    
    public function getBusdeparturesAction( $code )
    {
        $importer = $this->get('departures_board.importer');
        /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
        
        $repository = $this->getDoctrine()->getRepository('DeparturesBoardBundle:Busstop');

        // get result by date if too old than importer get new data
        $date = \DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
        $date->modify('-1 day');
        
        // find busstop
        try {
            $query = $repository->createQueryBuilder('b')
                ->where('b.updated >= :date')
                ->andWhere('b.code = :code')
                ->setParameter('date', $date)
                ->setParameter('code', $code)
                ->getQuery();
            $busstop = $query->getSingleResult();
        } catch ( \Doctrine\ORM\NoResultException $ex) {
            $importer->importDeparturesForBusstop($code);
            $busstop = $query->getSingleResult();
        }
        
        // another check
        if ( count( $busstop->getBusdepartures() ) <= 0 ) {
            $importer->importDeparturesForBusstop($code);
            $this->getDoctrine()->getManager()->refresh($busstop);
        }
        
        
        $view = $this->view($busstop->getBusdepartures(), 200)->setHeader('Access-Control-Allow-Origin', '*');;
        return $this->handleView($view);
    }
    
}
    

