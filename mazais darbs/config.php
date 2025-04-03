<?php


$host = "localhost";  //hostname aka mūsu lokais serveris         
$dbname = "darbs";    //datubāzes nosaukums         
$username = "root";    //noklusējuma mamp user ir root     
$password = "root";    //noklusējuma mamp parole ir root  

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password); 

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

} catch (PDOException $e) {   

    die("Database connection failed: " . $e->getMessage()); 
}