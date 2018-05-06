<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_product_orders = mysql_query("SELECT * FROM product_orders WHERE date LIKE '%2017-05-16%' ");
while($data_product_orders = mysql_fetch_array($select_product_orders))
{
	$update_product_orders = mysql_query("update product_orders SET id_order = '".$data_product_orders['id_store']."',id_store = '".$data_product_orders['id_order']."' WHERE id_product_order = '".$data_product_orders['id_product_order']."' ");
	
	if($update_product_orders)
	{echo"berhasil<br>";}
	else
	{echo"gagal";}

}
?>