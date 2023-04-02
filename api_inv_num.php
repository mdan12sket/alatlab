<?php

include 'conn.php';
$id_category = $_POST['id_category'];
$id_type = $_POST['id_type'];

$sql = "SELECT COUNT(id) AS total FROM stock WHERE category = '$id_category'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$total = $row['total'] + 1; 

if($total < 10)
	$num = "0000".$total;
else if($total < 100)
	$num = "000".$total;
else if($total < 1000)
	$num = "00".$total;
else if($total < 10000)
	$num = "0".$total;
else
	$num = $total;

$month_array = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

$month = (int)date("m");
$year = date("Y");

$sql_category = "SELECT * FROM t_category WHERE id = '$id_category'";
$query_category = mysqli_query($conn, $sql_category);
$row_category = mysqli_fetch_array($query_category);
$category = $row_category['code'];

$sql_type = "SELECT * FROM t_type WHERE id = '$id_type'";
$query_type = mysqli_query($conn, $sql_type);
$row_type = mysqli_fetch_array($query_type);
$type = $row_type['code'];

$inv_num = $category."/".$type."/".$num."/".$month_array[$month]."/".$year;
echo $inv_num;

?>