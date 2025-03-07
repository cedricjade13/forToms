<?php
// app/config/conf.php
require_once 'config.php'; // Include the config file

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>