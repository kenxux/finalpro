<?php
// File: db_connect.php

$host = "localhost";//server host
$user = "root"; // Default user for local MySQL installations
$password = ""; // Default password for root is empty
$dbname = "SMIS_db"; // Updated database name

// Create a connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
