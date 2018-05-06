<?php

/**
 * This script is an example PHP script that shows you what can
 * be called by the store locator plugin. It is very simple, but
 * should help you understand how you can integrate the plugin
 * in YOUR application.
 *
 * We suppose here that you have a working MySQL server (provide
 * its connection information below), which contains a database
 * (storelocator), which itself contains a table, "stores". See
 * the "create_table.sql" and "example_data.sql" to reproduce this
 * example on your system.
 */

// Insert here the information to connect to your MySQL server.
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "etools";

$role = isset($_GET['role']) ? $_GET['role'] : '';
$ket = isset($_GET['ket']) ? $_GET['ket'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$distributor_code = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';

if($role=="Ado")
{
	$ado = "AND store.distributor_code = ".$distributor_code." AND store.motorist_type in (".$ket.") ";
}
else if($role=="Regional"){
	
	$ado = "AND store.regional = '".$distributor_code."' AND motorist.motorist_type in (".$ket.") ";
	
	
}
else{
	
	
	$ado= "";
}


$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
if ($distributor!="")
{$distributor = "AND store.distributor_code in (".$distributor.")"; }
else
{$distributor = ""; 
}


$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
if ($motorist_type!="")
{$motorist_type = "AND store.motorist_type in (".$motorist_type.")"; }
else
{$motorist_type = ""; 
}


$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
if ($channel!="")
{$channel = "AND channel_code in ('".$channel."')"; }
else
{$channel = ""; 
}

$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
if ($motorist!="")
{$motorist = "AND store.motorist_code in (".$motorist.")"; }
else
{$motorist = ""; 
}
//echo $motorist;


$day = isset($_GET['day']) ? $_GET['day'] : '';
if($day!="")
{
	$day = "AND day_visit in (".$day.")"; }
else
{
	$day = ""; 
}

$area = isset($_GET['area']) ? $_GET['area'] : '';
if($area!="")
{
	$area = "AND area in (".$area.")";  }
else
{
	$area = ""; 
}


$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
if($regional!="")
{
	$regional = "AND regional in (".$regional.")";  }
else
{
	$regional = ""; 
}





$month = isset($_GET['month']) ? $_GET['month'] : '';
$transaction_month = isset($_GET['transaction_month']) ? $_GET['transaction_month'] : '';

// Response is always JSON.
header('Content-type: application/json');

// Parameters
$lat = floatval("-6.203277");
$lng = floatval("106.845984");
if( !$lat || !$lng )
{
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	header("$protocol 400 Bad Request");
	die(json_encode(array('error' => "Wrong values for 'lat' and/or 'lng' parameters.")));
}

// SQL request. The complexe part is here to compute the distance
// between the position passed in the parameters and each store.
$product = isset($_GET['product']) ? $_GET['product'] : '';

if($product=="")
{
	
$sql = "SELECT *,store.customer_code as customer_code,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
		FROM store JOIN motorist ON motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code WHERE customer_status = 'active' AND status_latitude = 'yes' ".$motorist_type." ".$ado." ".$area." ".$regional."  ".$distributor." ".$motorist." ".$channel." ".$day." 
		HAVING distance <= 100000
		ORDER BY distance ASC";
}
else
{
	if($transaction_month=="yes")
	{
		$product = isset($_GET['product']) ? $_GET['product'] : '';
		if($product!="")
		{
			$query_product = "AND product_orders.id_product in (".$product.")" ;
		}

		$mo =	date('m');
		$year = date('y');
		if($tahun!='')
		{$year = $tahun;}
	
		if($month!="")
		{		
			$sql = "SELECT *,store.customer_code as customer_code,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
			FROM store LEFT JOIN product_orders ON product_orders.customer_code = store.customer_code ".$query_product." AND product_orders.date between '".$year.'-'.$month.'-01 00:00:00'."' AND  '".$year.'-'.$month.'-31 23:59:59'."'  WHERE customer_status = 'active' AND status_latitude = 'yes' ".$motorist_type." ".$ado." ".$area." ".$regional."  ".$distributor." ".$motorist." ".$channel." ".$day." AND product_orders.customer_code IS NOT NULL
			GROUP BY store.customer_code
			HAVING distance <= 100000
			ORDER BY distance ASC  ";
		}
		else
		{ 
			$sql = "SELECT *,store.customer_code as customer_code,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
			FROM store LEFT JOIN product_orders ON product_orders.customer_code = store.customer_code ".$query_product." AND product_orders.date between '".$year.'-'.$mo.'-01 00:00:00'."' AND  '".$year.'-'.$mo.'-31 23:59:59'."'  WHERE customer_status = 'active' AND status_latitude = 'yes' ".$motorist_type." ".$ado." ".$area." ".$regional."  ".$distributor." ".$motorist." ".$channel." ".$day." AND product_orders.customer_code IS NOT NULL
			GROUP BY store.customer_code
			HAVING distance <= 100000
			ORDER BY distance ASC  ";
		}
	}
	else
	{
		$product = isset($_GET['product']) ? $_GET['product'] : '';
		if($product!="")
		{
			$query_product = "AND product_orders.id_product in (".$product.")" ;
		}
		
		$mo =	date('m');
		$year = date('y');
		if($tahun!='')
		{$year = $tahun;}
		
		if($month!="")
		{	
			$sql = "SELECT *,store.customer_code as customer_code,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
			FROM store LEFT JOIN product_orders ON product_orders.customer_code = store.customer_code ".$query_product." AND product_orders.date between '".$year.'-'.$month.'-01 00:00:00'."' AND  '".$year.'-'.$month.'-31 23:59:59'."'  WHERE customer_status = 'active' AND status_latitude = 'yes' ".$motorist_type." ".$ado." ".$area." ".$regional."  ".$distributor." ".$motorist." ".$channel." ".$day." AND product_orders.customer_code IS NULL
			GROUP BY store.customer_code
			HAVING distance <= 100000
			ORDER BY distance ASC  ";
		}
		else
		{
			$sql = "SELECT *,store.customer_code as customer_code,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
			FROM store LEFT JOIN product_orders ON product_orders.customer_code = store.customer_code ".$query_product." AND product_orders.date between '".$year.'-'.$mo.'-01 00:00:00'."' AND  '".$year.'-'.$mo.'-31 23:59:59'."'  WHERE customer_status = 'active' AND status_latitude = 'yes' ".$motorist_type." ".$ado." ".$area." ".$regional."  ".$distributor." ".$motorist." ".$channel." ".$day." AND product_orders.customer_code IS NULL
			GROUP BY store.customer_code
			HAVING distance <= 100000
			ORDER BY distance ASC  ";	
		}
		
	}
}


// Connexion to MySQL server.
$mysqli = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if( !$mysqli ) {
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	header("$protocol 500 Internal Server Error");
	die(json_encode(array('error' => "Database connection error.")));
}

// Setting up the data encoding as UTF-8.
mysqli_set_charset($mysqli, 'utf8');

// We keep the stores in this array.
$nearbyStores = array();

// Execution of the SELECT query.
$res = @mysqli_query($mysqli, $sql);
if( $res ) {

	// For each stores...
	while( $store = @mysqli_fetch_assoc($res) ) {

		// We construct two strings containing the distance in kilometers and miles.
		$store['distance-kilometers'] = round($store['distance']) . ' km';
		$store['distance-miles'] = round($store['distance'] / 1.6) . ' mi';

		// We add the store to the result array.
		$nearbyStores[] = $store;

	}
}

// We return the stores in JSON format.
echo json_encode($nearbyStores);
