<?php

namespace DeparturesBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Busdeparture
 *
 * @ORM\Table(name="busdeparture")
 * @ORM\Entity(repositoryClass="DeparturesBoardBundle\Repository\BusdepartureRepository")
 */
class Busdeparture
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
     * @ORM\Column(name="daytype", type="string", length=255)
     */
    private $daytype;

    /**
     * @var string
     *
     * @ORM\Column(name="busnumber", type="string", length=255)
     */
    private $busnumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="direction", type="string", length=255)
     */
    private $direction;
    
    /**
     * @var array
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    
    /**
     * @var \DateTime 
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="Busstop", inversedBy="busdepartures")
     * @ORM\JoinColumn(name="busstop_id", referencedColumnName="id")
     */
    private $busstop;

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
     * Set busstop
     *
     * @param \DeparturesBoardBundle\Entity\Busstop $busstop
     *
     * @return Busdeparture
     */
    public function setBusstop(\DeparturesBoardBundle\Entity\Busstop $busstop = null)
    {
        $this->busstop = $busstop;

        return $this;
    }

    /**
     * Get busstop
     *
     * @return \DeparturesBoardBundle\Entity\Busstop
     */
    public function getBusstop()
    {
        return $this->busstop;
    }

    /**
     * Set daytype
     *
     * @param string $daytype
     *
     * @return Busdeparture
     */
    public function setDaytype($daytype)
    {
        $this->daytype = $daytype;

        return $this;
    }

    /**
     * Get daytype
     *
     * @return string
     */
    public function getDaytype()
    {
        return $this->daytype;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Busdeparture
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

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Busdeparture
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set busnumber
     *
     * @param string $busnumber
     *
     * @return Busdeparture
     */
    public function setBusnumber($busnumber)
    {
        $this->busnumber = $busnumber;

        return $this;
    }

    /**
     * Get busnumber
     *
     * @return string
     */
    public function getBusnumber()
    {
        return $this->busnumber;
    }

    /**
     * Set direction
     *
     * @param string $direction
     *
     * @return Busdeparture
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
