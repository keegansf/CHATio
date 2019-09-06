<?php 

include("session.php");

$_SESSION['pageStore'] = "index.php";

if(!isset($_SESSION['login_id'])) {
    header("location: login.php");
}


?>