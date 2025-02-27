<?php
$dsn = "mysql:host=localhost;dbname=register;charset=utf8mb4"; 
$username = "root";  
$password = "root";  

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            echo "<script>alert('All fields are required!'); window.location.href='index.php';</script>";
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $checkEmail = $pdo->prepare("SELECT email FROM users WHERE email = :email");
        $checkEmail->execute([':email' => $email]);
        if ($checkEmail->fetch()) {
            echo "<script>alert('This email is already registered!'); window.location.href='index.php';</script>";
            exit();
        }

        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':password' => $hashed_password
        ]);

        echo "<script>alert('Registration Successful!'); window.location.href='index.php';</script>";
    }

} catch (PDOException $e) {
    echo "<script>alert('Database Error: " . $e->getMessage() . "'); window.location.href='index.php';</script>";
}
?>
