<?php
//var_dump('pouette');die;
include_once 'C:\wamp\www\crm_tools\utility.php';

$query_id = null;
//var_dump($query_id);die;
//$bdd = connexion_base_mysql_new();
////	var_dump($bdd);die;
//	$query_insert = "SELECT * FROM crm_queries_result WHERE queryDate = '2017-06-15' AND query_id = '177'";
////	echo $query_insert;die;
//	$select = $bdd->query($query_insert);
////	var_dump($select);die;
//	foreach($select as $row){
//		
//		var_dump($row);
//		
//	}
function load_value()
{
	
	$page = '';
//	$page = $_GET['page'];
	$bdd_mysql = connexion_base_mysql_new();
	$date = date("Y-m-d");
	$date_before = date('Y-m-d',strtotime(date('Y-m-d'))-86400);
	if ($page == '')
	{
		$query_mysql = "SELECT * FROM crm_queries where enableHistory = 1\n";
		
	}
	else 
	{
		$query_mysql = "SELECT * FROM crm_queries where enableHistory = 1 and pageName = '$page'";
	}
//	echo $query_mysql;die;
	if ($page == NULL)
		{
//			var_dump($date);die;
			$bdd_mysql->exec("delete from crm_queries_result where QueryDate = '$date'");
			echo "\n";
			echo 'delete <br/>';
			echo "toto <br/>";
		}
//	echo $query_mysql;die;
	$result_mysql = $bdd_mysql->query($query_mysql);
	foreach($result_mysql as $row_mysql)
	{
//		var_dump($row_mysql);die;
//		echo date('h:i:s') . '<br>';
		$string = $row_mysql['queryText'];
//		var_dump($string);die;
		//$result_query = get_connexion($bdd_mysql, $row_mysql['connexion']);
		$bdd_oracle = connexion_base_oracle($row_mysql['connexion']);
		if ($row_mysql['pageName'] == 'insert_value')
		{
			$string = str_replace("value_date", $date_before, $row_mysql['queryText']);
			echo "\n";
			echo $date_before;
			echo "\n";
		}
		else
		{
			$string = str_replace("value_date", $date, $row_mysql['queryText']);
		}
		$prepared_statement = oci_parse($bdd_oracle, $string);
		
		$result = oci_execute($prepared_statement);
//		var_dump($result);die;
		if(!result)
		{
			echo "Error running : " ;
			echo "\n" . $string. "\n<br>";
		}
				
		
		$i = 0;
		while (($row = oci_fetch_row($prepared_statement)) != false) 
		{
			foreach($row as $row_useless)
			{
				$query_string = "INSERT INTO crm_queries_reslut (queryName,queryResult,queryDate) VALUES('$row_mysql[Query_Name]', '$row[$i]', '$date')";
				echo $query_string . "\n<br>";
				$bdd_mysql->exec($query_string);
				$i++;
			}
			$i = 0;
		}
	}
	$bdd_mysql->commit();
}

load_value();

?>