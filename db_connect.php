<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "login"; 

try {
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
