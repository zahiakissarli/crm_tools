<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;





/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="logs_view")
 */
class LogsView {

    private function __construct() {}


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name_root", type="string", length=255)
     */
    private $fileNameRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255)
     */
    private $fileName;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="iteration", type="integer")
     */
    private $iteration;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_client", type="integer")
     */
    private $nbr_client;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_event", type="integer")
     */
    private $nbr_event;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_booking", type="integer")
     */
    private $nbr_booking;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="file_date", type="date")
     */
    private $file_date;

    /**
     * @var string
     *
     * @ORM\Column(name="graph_name", type="string", length=255)
     */
    private $graph_name;

    /**
     * @var int
     *
     * @ORM\Column(name="average_duration_job", type="integer")
     */
    private $average_duration_job;

    /**
     * @var Time
     *
     * @ORM\Column(name="duration_string", type="time")
     */
    private $durationString;


}
