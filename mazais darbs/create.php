<?php
require 'config.php'; // Iekļauj datubāzes savienojumu

// Pārbauda, vai forma ir nosūtīta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $d_o_b = $_POST['d_o_b'] ?? '';
    $password = $_POST['password'] ?? '';

    $error_message = ''; // Kļūdu ziņojums
    $success_message = ''; // Veiksmes ziņojums

    // Pārbauda, vai parole ir ievadīta
    if (empty($password)) {
        $error_message = 'Parole ir obligāta!';
    }

    // Ja nav kļūdu, ievada lietotāju datubāzē
    if (empty($error_message)) {
        try {
            // Paroles šifrēšana
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Saglabā lietotāja datus datubāzē
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, d_o_b, password) VALUES (:first_name, :last_name, :phone, :email, :d_o_b, :password)");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':d_o_b', $d_o_b);
            $stmt->bindParam(':password', $hashed_password);

            $stmt->execute();
            $success_message = 'Lietotājs veiksmīgi izveidots!';
        } catch (PDOException $e) {
            $error_message = 'Radās kļūda: ' . $e->getMessage();
        }
    }
}

require 'index.html'; // Atsaucas uz HTML failu, lai atgrieztu formu ar rezultātiem
?>
