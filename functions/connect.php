<?php 

$us = "admin";
$passw = "typeonegative";
$host = "localhost";
$db = "TI239";

$connect = mysqli_connect($host, $us, $passw, $db);

if(!$connect){
	die('Error connect to database');
}











?>