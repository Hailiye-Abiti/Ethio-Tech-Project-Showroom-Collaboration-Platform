<?php
$host = "localhost";
$user = "root";
$pass = ""; // በ XAMPP/WAMP ላይ default ባዶ ነው
$dbname = "ethio_tech_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
