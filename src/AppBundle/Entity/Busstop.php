<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Busstop
 *
 * @ORM\Table(name="busstop")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BusstopRepository")
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
     * @param \AppBundle\Entity\Busdeparture $busdeparture
     *
     * @return Busstop
     */
    public function addBusdeparture(\AppBundle\Entity\Busdeparture $busdeparture)
    {
        $this->busdepartures[] = $busdeparture;

        return $this;
    }

    /**
     * Remove busdeparture
     *
     * @param \AppBundle\Entity\Busdeparture $busdeparture
     */
    public function removeBusdeparture(\AppBundle\Entity\Busdeparture $busdeparture)
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
}
