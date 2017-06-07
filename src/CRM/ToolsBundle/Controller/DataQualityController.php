<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DataQualityController extends Controller
{

    public function errorsAnalysisAction(){
//        phpinfo();
        $em = $this->getDoctrine()->getManager('customer');
        $test = $em->getRepository('CRMToolsBundle:CrmQueries')
            ->requestFromUcrTest();

        return $this->render('CRMToolsBundle:DataQuality:errorsAnalysis.html.twig');

//        var_dump($test);die;

    }
}
