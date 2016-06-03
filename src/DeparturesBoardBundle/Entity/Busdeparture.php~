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
     * @var int
     *
     * @ORM\Column(name="daytype", type="string", length=255)
     */
    private $daytype;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array")
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
     * Set data
     *
     * @param array $data
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
     * @return array
     */
    public function getData()
    {
        return $this->data;
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
}
