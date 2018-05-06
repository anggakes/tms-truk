<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_visit = mysql_query("SELECT * FROM visit");
while($data_visit = mysql_fetch_array($select_visit))
{
		$select_store = mysql_query("SELECT * FROM table1_seq WHERE customer_code = '".$data_visit['customer_code']."' ");
		$data_store = mysql_fetch_array($select_store);
		$number = sprintf('%08d',$data_store['id']);
		$customer_code_new = $data_store['distributor_code'].'-'.$number;
		
		$update_visit = mysql_query("UPDATE visit set customer_code='".$customer_code_new."' WHERE id_visit ='".$data_visit['id_visit']."' ");
		if($update_visit)
		{echo"berhasil";}
		else
		{echo"gagal";}
	
	
}


?>