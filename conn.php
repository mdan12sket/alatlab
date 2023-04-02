<?php
session_start();
$server = "localhost";
$user = "root";
$password = "";
$db = "alatlab";

define("DEFAULT_TANGGAL", "2000-01-01 00:00:00");

$conn = mysqli_connect($server, $user, $password, $db);

//$db             = '';  
//$user           = '';               
//$password       = '';  
//$conn_firebird  = ibase_connect($db,$user,$password) or die("<br>" . ibase_errmsg());