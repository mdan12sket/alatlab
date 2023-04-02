<?php
//Jika belum login

if(isset($_SESSION['user_email_address'])){

} else {
    header('location:login.php');
}
?>