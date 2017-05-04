<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmJobs
 *
 * @ORM\Table(name="crm_jobs")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmJobsRepository")
 */
class CrmJobs
{

    /**
     * @ORM\ManyToOne(targetEntity="CRM\ToolsBundle\Entity\GraphName")
     * @ORM\JoinColumn(name="idGraph", referencedColumnName="id", nullable=false)
     */
    private $idGraph;

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
     * @ORM\Column(name="jobName", type="string", length=255, unique=true)
     */
    private $jobName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="displayOrder", type="boolean")
     */
    private $displayOrder;


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
     * Set jobName
     *
     * @param string $jobName
     * @return CrmJobs
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;

        return $this;
    }

    /**
     * Get jobName
     *
     * @return string 
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return CrmJobs
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set displayOrder
     *
     * @param boolean $displayOrder
     * @return CrmJobs
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder
     *
     * @return boolean 
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set graphName
     *
     * @param \CRM\ToolsBundle\Entity\GraphName $graphName
     * @return CrmJobs
     */
    public function setGraphName(\CRM\ToolsBundle\Entity\GraphName $graphName)
    {
        $this->graphName = $graphName;

        return $this;
    }

    /**
     * Get graphName
     *
     * @return \CRM\ToolsBundle\Entity\GraphName 
     */
    public function getGraphName()
    {
        return $this->graphName;
    }

    /**
     * Set idGraph
     *
     * @param \CRM\ToolsBundle\Entity\GraphName $idGraph
     * @return CrmJobs
     */
    public function setIdGraph(\CRM\ToolsBundle\Entity\GraphName $idGraph)
    {
        $this->idGraph = $idGraph;

        return $this;
    }

    /**
     * Get idGraph
     *
     * @return \CRM\ToolsBundle\Entity\GraphName 
     */
    public function getIdGraph()
    {
        return $this->idGraph;
    }
}
