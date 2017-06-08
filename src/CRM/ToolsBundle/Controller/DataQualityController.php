<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DataQualityController extends Controller
{

    public function errorsAnalysisAction(){
//        phpinfo();
        $end_date = new \DateTime();
        $start_date = new \DateTime();
        $start_date->modify('-10 day');

        $date_array = array();
        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $groupsName = $em->getRepository('CRMToolsBundle:CrmQueriesResult')
            ->getGroupsName();

        $em = $this->getDoctrine()->getManager();
        $dataQualities = $em->getRepository('CRMToolsBundle:CrmQueriesResult')
            ->getDataQualityTable($date_array);
//        var_dump($dataQualities);die;

        return $this->render('CRMToolsBundle:DataQuality:errorsAnalysis.html.twig',array(
            'dataQualities' => $dataQualities,
            'groupsName'   => $groupsName,
            'date_array'    => $date_array
        ));

//        var_dump($test);die;

    }
}
