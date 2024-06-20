<?php
session_start();
session_unset();
session_destroy();
if(!isset($_SESSION['user'])) header('location:menu.php');
?>