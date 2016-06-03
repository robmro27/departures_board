<?php

namespace DeparturesBoardBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    
class ApiController extends FOSRestController {
    
    
    public function getBusstopsAction() 
    {
        
        $repository = $this->getDoctrine()->getRepository('DeparturesBoardBundle:Busdeparture');
        $data = $repository->findAll();
        
        $view = $this->view($data, 200);

        return $this->handleView($view);
        
    }
    
    
    
}
    

