<?php

namespace DeparturesBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use DeparturesBoardBundle\Entity\Busstop;

use Goutte\Client;

class BusstopController extends Controller
{
    
    public function importAction()
    {
        $client = new Client();
        
        $crawler = $client->request('GET', 'http://www.mzk.pl/');
        // $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);
        
        $link = $crawler->selectLink('Rozkład jazdy wg przystanków')->link();
        $crawler = $client->click($link);
        
        $this->truncateTable(\DeparturesBoardBundle\Entity\Busstop::class); // truncate old data
            
        $crawler->filter('select#select_przystanki option')->each(function ($node) {
            
            
            $busstop = new Busstop();
            /* @var $busstop DeparturesBoardBundle\Entity\Busstop */
            $busstop->setName($node->text());
            $busstop->setCode($node->attr('value'));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($busstop); 
            $em->flush(); 
            
        });
        
        return new \Symfony\Component\HttpFoundation\Response('null');
        
    }
    
    
    
    
    public function importBusstopAction()
    {
        
        $code = 004;
        
        $client = new Client();
        
        $crawler = $client->request('GET', 'http://www.mzk.pl/rozklady/?co=rozklad_dla_przystanku&wybrany=p' . $code);
        // $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);
        
        $crawler->filter('h2')->each(function ($node) {
            
            echo '<pre>';
            print_r( $node->text() );
            echo '</pre>';
            
        });
        
        return new \Symfony\Component\HttpFoundation\Response('null');
        
    }
    
    
    
    
    private function truncateTable( $className )
    {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getClassMetadata($className);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        }
    }
    
}
