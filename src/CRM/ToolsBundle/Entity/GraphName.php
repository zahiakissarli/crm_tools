<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GraphName
 *
 * @ORM\Table(name="graph_name")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\GraphNameRepository")
 */
class GraphName
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
     * @ORM\Column(name="nameGraph", type="string", length=255, unique=true)
     */
    private $nameGraph;

    /**
     * @var bool
     *
     * @ORM\Column(name="enableDisplay", type="boolean")
     */
    private $enableDisplay;

    /**
     * @var int
     *
     * @ORM\Column(name="averageDurationJob", type="integer", nullable=true)
     */
    private $averageDurationJob;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set enableDisplay
     *
     * @param boolean $enableDisplay
     * @return GraphName
     */
    public function setEnableDisplay($enableDisplay)
    {
        $this->enableDisplay = $enableDisplay;

        return $this;
    }

    /**
     * Get enableDisplay
     *
     * @return boolean
     */
    public function getEnableDisplay()
    {
        return $this->enableDisplay;
    }

    /**
     * Set averageDurationJob
     *
     * @param integer $averageDurationJob
     * @return GraphName
     */
    public function setAverageDurationJob($averageDurationJob)
    {
        $this->averageDurationJob = $averageDurationJob;

        return $this;
    }

    /**
     * Get averageDurationJob
     *
     * @return integer
     */
    public function getAverageDurationJob()
    {
        return $this->averageDurationJob;
    }

    /**
     * Set nameGraph
     *
     * @param string $nameGraph
     * @return GraphName
     */
    public function setNameGraph($nameGraph)
    {
        $this->nameGraph = $nameGraph;

        return $this;
    }

    /**
     * Get nameGraph
     *
     * @return string 
     */
    public function getNameGraph()
    {
        return $this->nameGraph;
    }
}
