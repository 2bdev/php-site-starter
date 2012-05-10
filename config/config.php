<?php 

define("SITE_URL",""); //Always include trailing slash
define("ADMIN_URL",SITE_URL."admin/"); //If there is a custom backend
define("SITE_NAME","");
define("SERVER_PATH","");

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