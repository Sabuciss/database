<?php
require 'config.php'; // Iekļaujam datubāzes savienojumu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iegūstam datus no formas un noņemam liekās atstarpes
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $d_o_b = trim($_POST['d_o_b'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    // ✅ Vārds un uzvārds (Atļautas latviešu garumzīmes)
    if (!preg_match("/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]+$/u", $first_name)) {
        $errors[] = 'Vārdā drīkst būt tikai burti!';
    }
    if (!preg_match("/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]+$/u", $last_name)) {
        $errors[] = 'Uzvārdā drīkst būt tikai burti!';
    }

    // ✅ Telefona numurs (8 cipari)
    if (!preg_match("/^\d{8}$/", $phone)) {
        $errors[] = 'Telefona numuram jābūt tieši 8 cipariem!';
    }

    // ✅ E-pasta validācija un unikāls e-pasts
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@(gmail\.com|inbox\.lv|yahoo\.com)$/", $email)) {
        $errors[] = 'Nepareizs e-pasta formāts! Atļauti tikai: @gmail.com, @inbox.lv, @yahoo.com';
    } else {
        // Pārbauda, vai e-pasts jau eksistē datubāzē
        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = :email");
        $checkEmail->execute([':email' => $email]);
        if ($checkEmail->fetch()) {
            $errors[] = 'Šis e-pasts jau ir reģistrēts!';
        }
    }

    // ✅ Paroles validācija
    if (strlen($password) < 15 || 
        !preg_match("/[A-Z]/", $password) || 
        !preg_match("/[a-z]/", $password) || 
        !preg_match("/\d/", $password) || 
        !preg_match("/[@$!%*?&]/", $password)) {
        $errors[] = 'Parolei jābūt vismaz 15 simboliem un jāiekļauj lielais/mazais burts, cipars un speciālais simbols!';
    }

    // ✅ Dzimšanas datuma pārbaude (ne nākotnes datums)
    $today = new DateTime();
    $dob = new DateTime($d_o_b);
    if ($dob >= $today) {
        $errors[] = 'Dzimšanas datumam jābūt pagātnē!';
    }

    // Ja ir kļūdas, izvadām tās un apturam procesu
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li style='color: red;'>$error</li>";
        }
        echo "</ul>";
        exit();
    }

    // ✅ Ja viss pareizi, saglabājam lietotāju datubāzē
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, d_o_b, password) 
                               VALUES (:first_name, :last_name, :phone, :email, :d_o_b, :password)");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':phone' => $phone,
            ':email' => $email,
            ':d_o_b' => $d_o_b,
            ':password' => $hashed_password
        ]);

        // Pāradresē uz read.php pēc veiksmīgas reģistrācijas
        header("Location: read.php");
        exit();
    } catch (PDOException $e) {
        // Nepārliecinieties, ka lietotājiem tiek izvadīta detalizēta kļūda
        error_log($e->getMessage()); // Saglabā kļūdu servera žurnālā
        echo "<p style='color: red;'>Radās kļūda, mēģiniet vēlreiz vēlāk.</p>";
    }
}
?>
