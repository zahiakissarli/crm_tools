<?php

namespace CRM\ToolsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMToolsBundle:Monitoring:homepage.html.twig');
    }

    public function graphAction(Request $request)
    {

        $end_date = new \DateTime();

        $start_date = new \DateTime();
        $start_date->modify('-7 day');

        $star_day_display= $start_date->format('d-m-Y');
        $end_day_display= $end_date->format('d-m-Y');

        $date_array= array();
        while($start_date<=$end_date){
            array_push($date_array,$start_date->format('d-m-Y'));
            $start_date->modify('+1 day');
        }

        $start_date= $start_date->modify('-8 day');

        $week_array= array();

        $start_week_1 = clone $start_date->modify('-8 day');
        $start_week_1 = $start_week_1->format('d-m-Y');
        $end_week_1 = clone $start_date->modify('+7 day');
        $end_week_1= $end_week_1->format('d-m-Y');
        $week_array[]= array(
            '0' =>$start_week_1,
            '1' =>$end_week_1,
        );

        $start_month = clone $start_date->modify('-23 day');
        $start_month = $start_month->format('d-m-Y');
        $end_month = clone $end_date;
        $end_month = $end_month->format('d-m-Y');
        $week_array[]= array(
            '0' =>$start_month,
            '1' =>$end_month,
        );

        $end_month_1= clone $start_date;
        $end_month_1 = $end_month_1->format('d-m-Y');
        $start_month_1= clone $start_date->modify('-31 day');
        $start_month_1 = $start_month_1->format('d-m-Y');
        $week_array[]= array(
            '0' =>$start_month_1,
            '1' =>$end_month_1,
        );

        return $this->render('CRMToolsBundle:Monitoring:graphPerformance.html.twig', array(
            'startDate'  => $star_day_display,
            'endDate'    => $end_day_display,
            'date_array' => $date_array,
            'week_array' => $week_array,
        ));
    }

    public function creatAction()
    {
        $graph = new GraphName();
        $graph->setName('UCR_TABLES_DE_REF');
        $graph->setEnableDisplay('1');
        $graph->setAverageDurationJob(120);

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($graph);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$graph->getId());
    }

    public function displayAction()
    {
        $em= $this->getDoctrine()->getEntityManager();
        $graphs = $em->getRepository("CRMToolsBundle:GraphName")->recupeWithWhere();

//        var_dump($graphs);
        foreach ($graphs as $graph){
            var_dump('le graph '.$graph['id']);
//            return new Response('le premier graph ');
        }die;


    }

    public function logsViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $test= $em->getRepository("CRMToolsBundle:LogsView")->findAll();

        var_dump($test);die;


        return new Response('test');
    }

}


