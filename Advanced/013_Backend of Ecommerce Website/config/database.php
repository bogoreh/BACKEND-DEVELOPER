<?php
// Simple database configuration (using MySQLi)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ecommerce_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>