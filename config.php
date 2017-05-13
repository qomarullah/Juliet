<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uxp2reflex";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$servername_prem = "10.2.116.224";
//$username_prem = "root";
//$password_prem = "";



$servername_wl = "localhost";
$username_wl = "root";
$password_wl = "";
$dbname_wl = "reflex_premium_whitelist";

// Create connection
$conn_wl = new mysqli($servername_wl, $username_wl, $password_wl, $dbname_wl);
// Check connection
if ($conn_wl->connect_error) {
    die("Connection failed: " . $conn_wl->connect_error);
}


$servername_prem = "localhost";
$username_prem = "root";
$password_prem = "";
$dbname_prem = "reflex_premium_whitelist";

// Create connection
$conn_prem = new mysqli($servername_prem, $username_prem, $password_prem, $dbname_prem);
// Check connection
if ($conn_prem->connect_error) {
    die("Connection failed: " . $conn_prem->connect_error);
}


$servername_mass = "localhost";
$username_mass = "root";
$password_mass = "";
$dbname_mass = "reflex";


// Create connection
$conn_mass = new mysqli($servername_mass, $username_mass, $password_mass, $dbname_mass);
// Check connection
if ($conn_mass->connect_error) {
    die("Connection failed: " . $conn_mass->connect_error);
}


//convert export oracle
$jndi="jdbc:oracle:thin:@10.251.38.228:1521:ODUXP;uat_mappingtools;uat_mappingtools";
$prefix="PROD10MAY_";
$folder="D://webapps/juliet/temp/"

?> 