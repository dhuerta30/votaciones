<?php

$host = "localhost";
$dbname = "votaciones";
$username = "root"; 
$password = "";

function conexion(){
	global $host, $dbname, $username, $password;

	$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}