<?php
$host = "localhost";
$dbname = "upload";
$username = "root";
$password = "root";

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // atļauj jeb izmet erroru ja sanāk
    
    echo "database connected successfully!<br>";

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());
}
?>