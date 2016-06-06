<?php

namespace DeparturesBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Busdeparturetime
 *
 * @ORM\Table(name="busdeparturetime")
 * @ORM\Entity(repositoryClass="DeparturesBoardBundle\Repository\BusdeparturetimeRepository")
 */
class Busdeparturetime
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="departure", type="string", length=10)
     */
    private $departure;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set departure
     *
     * @param string $departure
     *
     * @return Busdeparturetime
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }
}

