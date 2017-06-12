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

    public function reloadRequestAction($query_id){

        $current_date= new \DateTime();
        $current_date= $current_date->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        $queryText = $em->getRepository('CRMToolsBundle:CrmQueriesResult')
            ->getOneQueryText($query_id, $current_date);
//            ->reloadRequestOneQuery($query_id, $current_date);

        $em = $this->getDoctrine()->getManager('customer');
        $dataQualities = $em->getRepository('CRMToolsBundle:CrmQueriesResult')
            ->getResultFromUcr($queryText);
//        var_dump($dataQualities);die;

        return $this->redirect( $this->generateUrl('crm_errors_analysis'));

    }

    public function displayAction(){

        $em = $this->getDoctrine()->getManager('customer');
        $groupsName = $em->getRepository('CRMToolsBundle:CrmQueriesResult')
            ->test();
        var_dump($groupsName);die;


        $date = date("Y-m-d");
        $date_before = date('Y-m-d',strtotime(date('Y-m-d'))-86400);
//        var_dump($date);die;
//        if ($page == '')
//        {
//            $query_mysql = "SELECT * FROM crm_queries where enable_history = 1";

//        }
//        else
//        {
//            $query_mysql = "SELECT * FROM query_qualite_donnee where enable_history = 1 and page = '$page'";
//        }
//        if ($page == NULL)
//        {
//            $bdd_mysql->exec("delete from result_quality where Query_Date = '$date'");
//            echo "\n";
//            echo 'delete';
//            echo "\n";
//        }
//        echo $query_mysql;die;

//        $em = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT Q FROM CRMToolsBundle:CrmQueries Q WHERE Q.enableHistory = 1");
        $result = $query->getResult();

//        var_dump($result);die;
//        $result_mysql = $bdd_mysql->query($query_mysql);
        foreach($result as $row_mysql)
        {
//            echo date('h:i:s') . '<br>';
//            var_dump($row_mysql);die;

            $string = $row_mysql->getQueryText();
//            var_dump($string);die;


            //$result_query = get_connexion($bdd_mysql, $row_mysql['connexion']);
//            $bdd_oracle = connexion_base_oracle($row_mysql['connexion']);
            if ($row_mysql->getPageName() == 'insert_value')
            {
                $string = str_replace("value_date", $date_before, $row_mysql['Query']);
                echo "\n";
                echo $date_before;
                echo "\n";
            }
            else
            {
                $string = str_replace("value_date", $date, $row_mysql->getQueryText());
                var_dump($string);die;
            }
//            $prepared_statement = oci_parse($bdd_oracle, $string);

            $result = oci_execute($prepared_statement);
            if(!result)
            {
                echo "Error running : " ;
                echo "\n" . $string. "\n<br>";
            }

            $result= 25;
            $i = 0;
            while (($row = oci_fetch_row($prepared_statement)) != false)
            {
                foreach($row as $row_useless)
                {
                    $query_string = "INSERT INTO result_quality(Query_Name,Query_result,Query_Date) VALUES('$row_mysql[Query_Name]', '$row[$i]', '$date')";
                    echo $query_string . "\n<br>";
                    $bdd_mysql->exec($query_string);
                    $i++;
                }
                $i = 0;
            }
        }
        $bdd_mysql->commit();
        var_dump('toto');die;
    }
}
