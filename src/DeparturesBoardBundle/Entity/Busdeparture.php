<?php

namespace DeparturesBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Busdeparture
 *
 * @ORM\Table(name="busdeparture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BusdepartureRepository")
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
     * @ORM\Column(name="weekday", type="smallint")
     */
    private $weekday;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array")
     */
    private $data;

    
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
     * Set weekday
     *
     * @param integer $weekday
     *
     * @return Busdeparture
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return int
     */
    public function getWeekday()
    {
        return $this->weekday;
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
     * @param \AppBundle\Entity\Busstop $busstop
     *
     * @return Busdeparture
     */
    public function setBusstop(\AppBundle\Entity\Busstop $busstop = null)
    {
        $this->busstop = $busstop;

        return $this;
    }

    /**
     * Get busstop
     *
     * @return \AppBundle\Entity\Busstop
     */
    public function getBusstop()
    {
        return $this->busstop;
    }
}
