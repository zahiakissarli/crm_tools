<?php

namespace CRM\ToolsBundle\Controller;


use CRM\ToolsBundle\Entity\LogsView;
use CRM\ToolsBundle\Form\LogsViewType;
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

//        $request = $this->getRequest();
////        $request->query->get('submit');
//        if($request->isMethod('GET')){
//            var_dump($request);
//        }
//        $test= 'ce paragraphe'. "\n";
//             $test.= ' j\'ajoute ça';

        $end_date = new \DateTime();

        $start_date = new \DateTime();
        $start_date->modify('-7 day');

        $star_day_display= $start_date->format('Y-m-d');
        $end_day_display= $end_date->format('Y-m-d');

        $date_array= array();
        while($start_date<=$end_date){
            array_push($date_array,$start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        $start_date= $start_date->modify('-8 day');

        $week_array= array();

        $start_week_1 = clone $start_date->modify('-8 day');
        $start_week_1 = $start_week_1->format('Y-m-d');
        $end_week_1 = clone $start_date->modify('+7 day');
        $end_week_1= $end_week_1->format('Y-m-d');
        $week_array[]= array(
            '0' =>$start_week_1,
            '1' =>$end_week_1,
        );

        $start_month = clone $start_date->modify('-23 day');
        $start_month = $start_month->format('Y-m-d');
        $end_month = clone $end_date;
        $end_month = $end_month->format('Y-m-d');
        $week_array[]= array(
            '0' =>$start_month,
            '1' =>$end_month,
        );

        $end_month_1= clone $start_date;
        $end_month_1 = $end_month_1->format('Y-m-d');
        $start_month_1= clone $start_date->modify('-31 day');
        $start_month_1 = $start_month_1->format('Y-m-d');
        $week_array[]= array(
            '0' =>$start_month_1,
            '1' =>$end_month_1,
        );
//        var_dump($start_month_1);die;
        $em = $this->getDoctrine()->getManager();
        $result_graph_avg = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayGraphTable($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
//            var_dump($result_graph_avg);die;



        $logsView = new LogsView();
        $form = $this->createForm (new LogsViewType(), $logsView);
        $request = $this->getRequest();

        return $this->render('CRMToolsBundle:Monitoring:graphPerformance.html.twig', array(
            'startDate'  => $star_day_display,
            'endDate'    => $end_day_display,
            'date_array' => $date_array,
            'week_array' => $week_array,
            'result_graph_avg' => $result_graph_avg,
            'form'=>$form->createView(),
        ));
    }

    public function logsViewAction()
    {

//        $em = $this->getDoctrine()->getManager();
//        $test= $em->getRepository("CRMToolsBundle:LogsView")->findAll();
//        var_dump($test);die;

        $end_date_array = new \DateTime();

        $start_date_array = new \DateTime();
        $start_date_array->modify('-7 day');

        $start_date= $start_date_array->format('Y-m-d');
        $end_date= $end_date_array->format('Y-m-d');

        $date_array= array();
        while($start_date_array<=$end_date_array){
            array_push($date_array,$start_date_array->format('Y-m-d'));
            $start_date_array->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayGraphTable($start_date, $end_date, $date_array);
        var_dump($result);die;


        return new Response('test');
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

}


