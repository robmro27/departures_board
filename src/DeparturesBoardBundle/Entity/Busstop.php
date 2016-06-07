<?php

namespace DeparturesBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Busstop
 *
 * @ORM\Table(name="busstop")
 * @ORM\Entity(repositoryClass="DeparturesBoardBundle\Repository\BusstopRepository")
 */
class Busstop
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var \DateTime 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @ORM\OneToMany(targetEntity="Busdeparture", mappedBy="busstop")
     */
    private $busdepartures;

    public function __construct()
    {
        $this->busdepartures = new ArrayCollection();
    }
    
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Busstop
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add busdeparture
     *
     * @param \DeparturesBoardBundle\Entity\Busdeparture $busdeparture
     *
     * @return Busstop
     */
    public function addBusdeparture(\DeparturesBoardBundle\Entity\Busdeparture $busdeparture)
    {
        $this->busdepartures[] = $busdeparture;

        return $this;
    }

    /**
     * Remove busdeparture
     *
     * @param \DeparturesBoardBundle\Entity\Busdeparture $busdeparture
     */
    public function removeBusdeparture(\DeparturesBoardBundle\Entity\Busdeparture $busdeparture)
    {
        $this->busdepartures->removeElement($busdeparture);
    }

    /**
     * Get busdepartures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBusdepartures()
    {
        return $this->busdepartures;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Busstop
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Busstop
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
