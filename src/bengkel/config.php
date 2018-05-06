<?php
class database {
	
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;
	
	
	
	function __construct ($a,$b,$c,$d)
	{
		$this->dbHost = $a;
		$this->dbUser = $b;
		$this->dbPass = $c;
		$this->dbName = $d;		
	}
		
	function connectMysql()
	{
		@mysql_connect($this->dbHost,$this->dbUser,$this->dbPass);
		@mysql_select_db($this->dbName);
		
	}
	
		
		
		
		
		
		function inputSMS($pesan,$noPengirim)
		{	
	
		
			$query = mysql_query ("INSERT INTO sms (no_pengirim,pesan) VALUES ('$noPengirim','$pesan')");

			if($query)
			{
				echo"Sukses";
			}
			else
			{
				echo"Gagal";
			}
			
		}
}


$host = 'localhost';
$user = 'root';
$pass = '';
$mydb = 'sogood_offline';
$db = new database($host,$user,$pass,$mydb);
$db->connectMysql();
?>
