<?php
require 'config.php'; // Pievieno datubāzes savienojumu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'] ?? '';

    if (!empty($userId)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete user"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
    }
}
?>