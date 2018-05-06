<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_product_orders = mysql_query("SELECT * FROM product_orders WHERE id_store != '0' ");
while($data_product_orders = mysql_fetch_array($select_product_orders))
{
		$select_store = mysql_query("SELECT * FROM store WHERE id_store = '".$data_product_orders['id_store']."' ");
		$data_store = mysql_fetch_array($select_store);
		
		$update_product_orders = mysql_query("UPDATE product_orders set customer_code='".$data_store['customer_code']."' WHERE id_product_order ='".$data_product_orders['id_product_order']."' ");
		if($update_product_orders)
		{echo"berhasil";}
		else
		{echo"gagal";}
	
	
}


?>