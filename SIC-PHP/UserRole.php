<?php
session_start();
include("connection.php");
if(!isset($_SESSION['UserID'])){
    header("location:index.php");
}
?>