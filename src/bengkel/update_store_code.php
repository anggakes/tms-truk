<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_store = mysql_query("SELECT * FROM store");
while($data_store = mysql_fetch_array($select_store))
{
		$select_table_sql = mysql_query("SELECT * FROM table1_seq WHERE motorist_code = '".$data_store['motorist_code']."' AND distributor_code = '".$data_store['distributor_code']."' AND customer_code = '".$data_store['customer_code']."' ");
		$data_table_sql = mysql_fetch_array($select_table_sql);
		
		$number = sprintf('%08d',$data_table_sql['id']);
		$customer_code_new = $data_store['distributor_code'].'-'.$number;
		//echo $customer_code_new."<br>";
		$update_store = mysql_query("UPDATE store set customer_code = '".$customer_code_new."' WHERE id_store = '".$data_store['id_store']."' ");
		if($update_store)
		{echo"berhasil"."<br>";}
		else
		{echo"gagal"."<br>";}
}
?>