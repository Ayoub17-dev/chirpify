<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Failed to connect DB" . $e->getMessage();
}
