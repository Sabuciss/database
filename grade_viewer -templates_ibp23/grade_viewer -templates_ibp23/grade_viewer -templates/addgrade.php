<?php
require_once 'config.php';

$student = trim($_POST['student'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$grade   = intval($_POST['grade'] ?? 0);

if ($student && $subject && $grade >= 1 && $grade <= 10) {
    $stmt = $pdo->prepare("SELECT id FROM students WHERE name = ?");
    $stmt->execute([$student]);
    $studentId = $stmt->fetchColumn();

    if (!$studentId) {
        $stmt = $pdo->prepare("INSERT INTO students (name) VALUES (?)");
        $stmt->execute([$student]);
        $studentId = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("SELECT id FROM subjects WHERE subject_name = ?");
    $stmt->execute([$subject]);
    $subjectId = $stmt->fetchColumn();

    if (!$subjectId) {
        $stmt = $pdo->prepare("INSERT INTO subjects (subject_name) VALUES (?)");
        $stmt->execute([$subject]);
        $subjectId = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("INSERT INTO grades (student_id, subject_id, grade) VALUES (?, ?, ?)");
    $stmt->execute([$studentId, $subjectId, $grade]);
}

header("Location: index.php");
exit;
