<?php
include ('../config.php');
include('../lib/datagrid/lazy_mofo.php');



$table="services_data_nomap";
$key="ID";


echo "
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='../lib/datagrid/style.css'>
</head>
<body>
<h1> TABLE ".$table."</h1>
"; 

// required for csv export
ob_start();

// connect to database with pdo
$dbh = new PDO("mysql:host=".$servername.";dbname=".$dbname.";", $username, $password);

// create LM object, pass in PDO connection
$lm = new lazy_mofo($dbh); 

// table name for updates, inserts and deletes
$lm->table = $table;

// identity / primary key column name
$lm->identity_name = $key;

// use the lm controller 
$lm->run();

echo "</body></html>";


?>