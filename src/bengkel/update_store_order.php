<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_order = mysql_query("SELECT * FROM orders ");
while($data_order = mysql_fetch_array($select_order))
{
		$select_store = mysql_query("SELECT * FROM table1_seq WHERE customer_code = '".$data_order['customer_code']."' ");
		$data_store = mysql_fetch_array($select_store);
		$number = sprintf('%08d',$data_store['id']);
		$customer_code_new = $data_store['distributor_code'].'-'.$number;
		
		$update_order = mysql_query("UPDATE orders set customer_code='".$customer_code_new."' WHERE id_order ='".$data_order['id_order']."' ");
		if($update_order)
		{echo"berhasil";}
		else
		{echo"gagal";}
	
	
}


?>