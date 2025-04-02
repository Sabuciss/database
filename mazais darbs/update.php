<?php
require 'config.php'; // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $d_o_b = $_POST['d_o_b'];


    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, phone = :phone, email = :email, d_o_b = :d_o_b WHERE id = :user_id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':d_o_b', $d_o_b);


    if ($stmt->execute()) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating user"]);
    }
}
?>