<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = trim($_POST['student']);
    $subject = trim($_POST['subject']);
    $grade = intval($_POST['grade']);

    $errors = [];

    // Tikai burti un atstarpes
    if (!preg_match("/^[a-zA-ZĀ-žā-ž\s]+$/u", $student)) {
        $errors[] = "❌ Student name must contain only letters and spaces.";
    }

    if (!preg_match("/^[a-zA-ZĀ-žā-ž\s]+$/u", $subject)) {
        $errors[] = "❌ Subject must contain only letters and spaces.";
    }

    if ($grade < 1 || $grade > 10) {
        $errors[] = "❌ Grade must be between 1 and 10.";
    }

    if (empty($errors)) {
        // Saglabāt studentu
        $stmt = $pdo->prepare("INSERT IGNORE INTO students (name) VALUES (:name)");
        $stmt->execute([':name' => $student]);

        $student_id = $pdo->query("SELECT id FROM students WHERE name = " . $pdo->quote($student))->fetchColumn();

        // Saglabāt subjectu
        $stmt = $pdo->prepare("INSERT IGNORE INTO subjects (subject_name) VALUES (:subject)");
        $stmt->execute([':subject' => $subject]);

        $subject_id = $pdo->query("SELECT id FROM subjects WHERE subject_name = " . $pdo->quote($subject))->fetchColumn();

        // Saglabāt atzīmi
        $stmt = $pdo->prepare("INSERT INTO grades (student_id, subject_id, grade) VALUES (:sid, :subid, :grade)");
        $stmt->execute([
            ':sid' => $student_id,
            ':subid' => $subject_id,
            ':grade' => $grade
        ]);

        header("Location: index.php?success=1");
        exit;
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
