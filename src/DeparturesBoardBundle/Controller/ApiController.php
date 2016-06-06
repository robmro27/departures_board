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
        
        $view = $this->view($data, 200);
        return $this->handleView($view);
        
    }
    
    
    public function getBusdeparturesAction( $code )
    {
        $repository = $this->getDoctrine()->getRepository('DeparturesBoardBundle:Busstop');

        // get result by date if too old than importer get new data
        $date = \DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
        $date->modify('-1 day');
        
        $query = $repository->createQueryBuilder('b')
            ->where('b.updated >= :date')
            ->andWhere('b.code = :code')
            ->setParameter('date', $date)
            ->setParameter('code', $code)
            ->getQuery();
        
        $busstop = $query->getSingleResult();
        
        if ( count( $busstop->getBusdepartures() ) <= 0 ) {
            
            $importer = $this->get('departures_board.importer');
            /* @var $importer \DeparturesBoardBundle\DependencyInjection\Importer */
            $importer->importDeparturesForBusstop($code);
            $this->getDoctrine()->getManager()->refresh($busstop);
            
        }
        
//        $departures = $busstop->getBusdepartures();
//        $criteria = Criteria::create()->where(Criteria::expr()->eq('daytype', 'sunday'));
//        $departures = $departures->matching($criteria);
        
        $view = $this->view($busstop->getBusdepartures(), 200);
        return $this->handleView($view);
    }
    
}
    

