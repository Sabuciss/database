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
       
        $errors = [];

        if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
            $errors[] = 'First name must only contain letters!';
        }

        if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
            $errors[] = 'Last name must only contain letters!';
        }

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $errors[] = 'All fields are required!';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format!';
        }

        $checkEmail = $pdo->prepare("SELECT email FROM users WHERE email = :email");
        $checkEmail->execute([':email' => $email]);
        if ($checkEmail->fetch()) {
            $errors[] = 'This email is already registered!';
        }

        if (strlen($password) < 9) {
            $errors[] = 'Password must be at least 9 characters long!';
        }
        if (!preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password) || !preg_match("/[@$!%*?&]/", $password)) {
            $errors[] = 'Password must contain at least one letter, one number, and one special character!';
        }

        if (!empty($errors)) {
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li style='color: red;'>$error</li>";
            }
            echo "</ul>";
            exit();
        }

        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        echo "<p style='color: green;'>Registration successful! You can now <a href='index.php'>login</a>.</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}
?>
