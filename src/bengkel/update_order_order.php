<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_store = mysql_query("SELECT * FROM store where motorist_type in (1,2) ");
while($data_store = mysql_fetch_array($select_store))
{
		
		
		$update_product_orders = mysql_query("UPDATE product_orders set customer_code = '".$data_store['customer_code']."' WHERE id_store = '".$data_store['id_store']."' ");
		$update_visit = mysql_query("UPDATE visit set customer_code = '".$data_store['customer_code']."' WHERE id_store = '".$data_store['id_store']."' ");
		$update_orders = mysql_query("UPDATE orders set customer_code = '".$data_store['customer_code']."' WHERE id_store = '".$data_store['id_store']."' ");
		if($update_orders AND $update_visit AND $update_product_orders)
		{echo"berhasil<br>";}
		else{echo"gagal";}
	
	
}


?>