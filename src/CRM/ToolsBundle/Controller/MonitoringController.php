<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 30/05/2017
 * Time: 09:42
 */

namespace CRM\ToolsBundle\Controller;


use CRM\ToolsBundle\Entity\LogsView;
use CRM\ToolsBundle\Form\LogsViewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;

class MonitoringController extends Controller
{

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
        $em = $this->getDoctrine()->getManager();

        /*Query for displaying the graph average*/
        $result_graph_avg = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayGraphTable($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Contacts*/
        $result_nb_contacts = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbContacts($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Contacts / Min*/
        $result_nb_contacts_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbContactsMin($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Events*/
        $result_nb_events = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbEvents($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking Midas*/
        $result_nb_booking_midas = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingMidas($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking Midas / Min*/
        $result_nb_booking_midas_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingMidasMin($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking AP*/
        $result_nb_booking_ap = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingAp($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking AP / Min*/
        $result_nb_booking_ap_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingApMin($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking BBOSS*/
        $result_nb_booking_bboss = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingBboss($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Query for displaying NB Booking BBOSS / Min*/
        $result_nb_booking_bboss_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingBbossMin($star_day_display, $end_day_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);

        /*Creat the datepicker form*/
        $logsView = new LogsView();
        $form = $this->createForm (new LogsViewType(), $logsView);
        $request = $this->getRequest();

        return $this->render('CRMToolsBundle:Monitoring:graphPerformance.html.twig', array(
            'startDate'  => $star_day_display,
            'endDate'    => $end_day_display,
            'date_array' => $date_array,
            'week_array' => $week_array,
            'result_graph_avg' => $result_graph_avg,
            'result_nb_contacts' => $result_nb_contacts,
            'result_nb_contacts_min' => $result_nb_contacts_min,
            'result_nb_events' => $result_nb_events,
            'result_nb_booking_midas' => $result_nb_booking_midas,
            'result_nb_booking_midas_min' => $result_nb_booking_midas_min,
            'result_nb_booking_ap' => $result_nb_booking_ap,
            'result_nb_booking_ap_min' => $result_nb_booking_ap_min,
            'result_nb_booking_bboss' => $result_nb_booking_bboss,
            'result_nb_booking_bboss_min' => $result_nb_booking_bboss_min,
            'form'=>$form->createView(),
        ));
    }









}
