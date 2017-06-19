<?php

namespace CRM\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CrmQueriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrmQueriesRepository extends EntityRepository
{

    public function getGroupsName(){

        $sqlGrpName = "SELECT DISTINCT groupName from crm_queries WHERE pageName = 'error_analysis'";
        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sqlGrpName);
        $query->execute();
        $groupsName = $query->fetchAll();
        return $groupsName;
    }

    public function getOneQueryText($query_id, $current_date){
        if($current_date){
            $sqlDeleteQueryResult = "DELETE FROM crm_queries_result WHERE queryDate = '" . $current_date . "' AND query_id = '" . $query_id . "'";
            $em = $this->getEntityManager();
            $query = $em->getConnection()->prepare($sqlDeleteQueryResult);
            $query->execute();
        }
        $sqlQueryText = "SELECT queryText FROM crm_queries WHERE id = '" . $query_id . "'";
//        echo $sqlQueryText;die;

        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sqlQueryText);
        $query->execute();
        $queryTextArray = $query->fetchAll();
        $queryText = $queryTextArray[0]['queryText'];
//        var_dump($queryText);die;
        return $queryText;
    }

}
