<?php
ini_set("memory_limit","32M");
ini_set("display_errors","on");
//error_reporting(E_ERROR);
error_reporting(E_ERROR | E_WARNING);
//error_reporting(E_ALL);

$config = new stdClass();

$config->dbHost="sandonato";
$config->dbUser="PABO";
$config->dbPass="m16RpP9";
$config->dbDatabase="POSTOASCOLTOBO";

$db=mysql_connect($config->dbHost,$config->dbUser,$config->dbPass) or die("Unable to connect db");
mysql_select_db($config->dbDatabase) or die ("Unable to select db");
?>
