<?php
require 'config.php'; // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'] ?? '';
    $last_name = $_POST['lastName'] ?? '';
    $phone= $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $email = $_POST['email'] ?? '';
    $d_o_b = $_POST['d_o_b'] ?? '';



    if (!empty($first_name)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, d_o_b) VALUES (:first_name, :last_name, :phone, :email, :d_o_b)");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':d_o_b', $d_o_b)

            $stmt->execute();
            echo json_encode(["status" => "success", "message" => "User created successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
?>