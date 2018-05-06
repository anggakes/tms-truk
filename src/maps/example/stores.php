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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';
$distributor_code = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';



// Response is always JSON.
header('Content-type: application/json');

// Parameters
$lat = floatval($_REQUEST['lat']);
$lng = floatval($_REQUEST['lng']);
if( !$lat || !$lng )
{
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	header("$protocol 400 Bad Request");
	die(json_encode(array('error' => "Wrong values for 'lat' and/or 'lng' parameters.")));
}

// SQL request. The complexe part is here to compute the distance
// between the position passed in the parameters and each store.
if($role=="Administrator")
{
$sql = "SELECT id_store,latitude,longitude,customer_name,address,districts,customer_status,urutan_motorist,channel_code,channel_name,motorist_code,foto_toko,motorist_name,distributor_name,customer_code,day_visit,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
		FROM store WHERE customer_status = 'active' AND status_latitude = 'yes' AND motorist_code Like '%".$motorist_code."%' AND customer_code like '%".$search."%'
		HAVING distance <= 100000
		ORDER BY distance ASC";
}
else if($role=="Ado")
{
$sql = "SELECT id_store,latitude,longitude,customer_name,address,districts,customer_status,urutan_motorist,channel_code,channel_name,motorist_code,foto_toko,distributor_name,customer_code,day_visit,
			((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lng - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
		FROM store WHERE customer_status = 'active' AND status_latitude = 'yes' AND motorist_code Like '%".$motorist_code."%' AND customer_code like '%".$search."%' AND distributor_code = '".$distributor_code."'
		HAVING distance <= 100000
		ORDER BY distance ASC";
	
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
