<?php

namespace CRM\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * LogsViewRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogsViewRepository extends EntityRepository
{

    public function findAllLogsView()
    {
        $query = $this->_em->createQuery( 'SELECT L.id, L.duration, L.averageDurationJob FROM CRMToolsBundle:LogsView L');
        $results = $query->getResult();

        return $results;
    }
    
     public function displayGraphTable($start_date, $end_date, $start_week_1, $end_week_1, $start_month, $end_month,
                                       $start_month_1, $end_month_1,$date_array){


         $sql= "SELECT
                    date_format(SEC_TO_TIME(avg(sum_duration_week/7)),'%T') as AVG_duration_week,
                    date_format(SEC_TO_TIME(avg(sum_duration_week_1/7)),'%T') as AVG_duration_week_1,
                    date_format(SEC_TO_TIME(avg(sum_duration_month/30)),'%T') as AVG_duration_month,
                    date_format(SEC_TO_TIME(avg(sum_duration_month_1/30)),'%T') as AVG_duration_month_1,
                  lol.*
                 FROM
                    (
                    SELECT
                      average_duration_job, 
                      graph_name, 
                      sum(case when file_date BETWEEN ('".$start_date."') AND ('".$end_date."') then duration end) AS sum_duration_week,
                      sum(case when file_date BETWEEN ('".$start_week_1."') AND ('".$end_week_1."') then duration end) AS sum_duration_week_1,
		              sum(case when file_date BETWEEN ('".$start_month."') AND ('".$end_month."') then duration end) AS sum_duration_month,
		              sum(case when file_date BETWEEN ('".$start_month_1."') AND ('".$end_month_1."') then duration end) AS sum_duration_month_1,
                      ";


         foreach($date_array as $key => $current_date) {
             $tmp = 1;
             $array_length = sizeof($date_array);

             $sql.= "SEC_TO_TIME(sum(case when file_date = '" . $current_date . "' then Duration end)) as '".$current_date."', \n";

             if ($key == ($array_length - $tmp)) {
                 $sql.= "sum(case when file_date = '" . $current_date . "' then Duration end) as 'duration_".$current_date."' \n";
             } else {
                 $sql.= "sum(case when file_date = '" . $current_date . "' then Duration end) as 'duration_".$current_date."', \n";
             }
         }

         $sql.= "FROM logs_view
                 WHERE file_date BETWEEN ('".$start_month_1."') AND ('".$end_date."')
                 group by graph_name) lol group by graph_name";

         $em = $this->getEntityManager();
         $query = $em->getConnection()->prepare($sql);
         $query->execute();


         $result = $query->fetchAll();

         return $result;

     }

}
