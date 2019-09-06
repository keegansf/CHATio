<?php

session_start(); //starting the session

if(session_destroy()) {
    header("location: login.php");
}

?>