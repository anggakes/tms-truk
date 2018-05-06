<?php
include"config.php";
ini_set('memory_limit', '-1');
$select_store = mysql_query("select * from store");
while($data_store = mysql_fetch_array($select_store))
{
		$insert_seq = mysql_query("INSERT INTO table1_seq (motorist_code,distributor_code,customer_code) VALUES ('$data_store[motorist_code]','$data_store[distributor_code]','$data_store[customer_code]') ");
		if($insert_seq){echo"berhasil";}else{echo"gagal";}
	
	
}


?>