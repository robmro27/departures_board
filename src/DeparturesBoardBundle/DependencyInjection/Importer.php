<?php

namespace DeparturesBoardBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use DeparturesBoardBundle\Entity\Busstop;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

/**
 * Class responsible for import data from departures site
 * @author rmroz
 */
class Importer {
    
    
    const DEPARTURES_SITE = 'http://www.mzk.pl/';
    const DEPARTURES_BUSSTOP_SITE = 'http://www.mzk.pl/rozklady/?co=rozklad_dla_przystanku&wybrany=p%s';
    
    const ODJAZDY_W_DNI_ROBOCZE = 'ODJAZDY_W_DNI_ROBOCZE';
    const ODJAZDY_W_SOBOTY = 'ODJAZDY_W_SOBOTY';
    const ODJAZDY_W_NIEDZIELE_I_SWIETA = 'ODJAZDY_W_NIEDZIELE_I_SWIETA';
    const UWAGA = 'UWAGA';
    
    private static $departuresLabelsArr = array (
        'ODJAZDY_W_DNI_ROBOCZE' => 'ODJAZDY W DNI ROBOCZE',
        'ODJAZDY_W_SOBOTY' => 'ODJAZDY W SOBOTY',
        'ODJAZDY_W_NIEDZIELE_I_SWIETA' => 'ODJAZDY W NIEDZIELE I ŚWIĘTA',
        'UWAGA' => 'UWAGA',
    );
    
    
    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    
    
    public function importDeparturesForBusstop( $busstopCode ) 
    {
        // go to busstop site
        $client = new Client();
        $crawler = $client->request('GET', sprintf(self::DEPARTURES_BUSSTOP_SITE, $busstopCode));
        
        // get all departure buses from this busstop
        $busessLinks = $crawler->filter('div#main ul')->eq(1)->children()->each(function (Crawler $node, $i) {
            return $node->filter('a')->attr('href');
        });
        
        // foreach bus get departures and direction
        foreach ( $busessLinks as $busLink ) {
            
            $crawler = $client->request('GET', $busLink);
            
            // get direction
            $direction = $crawler->filter('h2#kierunek')->text();
            $clearedDirection = trim(str_replace('Kierunek: ', '', $direction));
            
            // get departures
            $departures = $crawler->filter('table#odjazdy > tr > td')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            
            //group departures by day type
            $hourSettings = [];
            foreach ( $departures as $value ) {
                $value = trim($value);
                if ( in_array( $value , self::$departuresLabelsArr ) ) {
                    $key = array_search($value, self::$departuresLabelsArr); continue;
                }
                $hourSettings[$key][] = $value;

            }
            
            unset($hourSettings[self::UWAGA]);
            
            // clear prev and add new departures
            
                // clear
                $repository = $this->em->getRepository('DeparturesBoardBundle:Busstop');
                $busstop = $repository->findOneByCode($busstopCode);

                $repository = $this->em->getRepository('DeparturesBoardBundle:Busdeparture');
                $departures = $repository->findByBusstop($busstop);
                foreach ( $departures as $departure ) {
                    $this->em->remove($departure);    
                }
                $this->em->flush();
            
                //add
                foreach ( $hourSettings as $dayType => $hours ) {
                    $departures = new \DeparturesBoardBundle\Entity\Busdeparture();
                    $departures->setBusstop($busstop);
                    $departures->setDaytype($dayType);
                    $departures->setData(json_encode($hours));
                    $departures->setUpdated(new \DateTime());

                    $this->em->persist($departures);
                    $this->em->flush();
                }
                
        }
    }
    
    
    /**
     * Import list of busstops
     */
    public function importBusstops()
    {
        
        $client = new Client();
        /* @var $client Goutte\Client */
        
        $crawler = $client->request('GET', self::DEPARTURES_SITE);
        
        $link = $crawler->selectLink('Rozkład jazdy wg przystanków')->link();
        $crawler = $client->click($link);
        
        // truncate old data
        $this->truncateTable(\DeparturesBoardBundle\Entity\Busstop::class); 
            
        // get list of busstopps
        $crawler->filter('select#select_przystanki option')->each(function ($node) {
            
            $busstop = new Busstop();
            /* @var $busstop DeparturesBoardBundle\Entity\Busstop */
            
            $busstop->setName($node->text());
            $busstop->setCode($node->attr('value'));
            $busstop->setUpdated(new \DateTime());
            
            $this->em->persist($busstop); 
            $this->em->flush(); 
            
        });
    }
    
    
    /**
     * Truncate table by entity class name
     * @param string $className
     */
    private function truncateTable( $className )
    {
        
        $cmd = $this->em->getClassMetadata($className);
        $connection = $this->em->getConnection();
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
