<?php
require 'config.php'; // Iekļauj datubāzes savienojumu

// Iegūstam datus no POST pieprasījuma
$userId = $_POST['id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$d_o_b = $_POST['d_o_b'];

// Sagatavojam SQL pieprasījumu, lai atjauninātu lietotāja datus
$sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, phone = :phone, email = :email, d_o_b = :d_o_b WHERE id = :id";
$stmt = $conn->prepare($sql);

// Pievienojam parametrus
$stmt->bindParam(':first_name', $firstName);
$stmt->bindParam(':last_name', $lastName);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':d_o_b', $d_o_b);
$stmt->bindParam(':id', $userId);

// Izpildām pieprasījumu
if ($stmt->execute()) {
    echo "Lietotājs tika veiksmīgi atjaunināts!";
} else {
    echo "Radās kļūda, atjauninot lietotāju!";
}
?>
