<?php
require 'config.php'; // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'] ?? '';
    $last_name = $_POST['lastName'] ?? '';
    $tel = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($first_name)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, tel, email) VALUES (:first_name, :last_name, :tel, :email)");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);

            $stmt->execute();
            echo json_encode(["status" => "success", "message" => "User created successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
?>
