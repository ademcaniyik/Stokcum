<?php
    $servername = 'localhost';
    $username = 'root';
    $password = ''; // Make sure to add your actual password here if you have set one
    $dbname = 'inventory_system';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(Exception $e) {

    }
?>
