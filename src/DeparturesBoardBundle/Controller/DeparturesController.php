<?php

namespace DeparturesBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DeparturesController extends Controller
{

    public function showAction()
    {
        return $this->render('DeparturesBoardBundle:Departure:show.html.twig',[]);
    }
    
}
