<?php 

define("SITE_URL","");
define("SITE_NAME","");

define("DB_HOST","");
define("DB_USER","");
define("DB_PASS","");
define("DB_NAME","");

function db_connect(){
	$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
	if (!$con){ die('Could not connect: ' . mysql_error()); }
	mysql_select_db(DB_NAME, $con);
}

?>