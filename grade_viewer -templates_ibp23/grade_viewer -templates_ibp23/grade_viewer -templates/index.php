<?php include 'fetch_grades.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Grade Viewer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>📚 Student Grade Viewer</h1>

<form method="get" style="text-align: center; margin-bottom: 30px;">
  <label for="student">👤 Student:</label>
  <select name="student" id="student">
    <option value="">All Students</option>
    <?php foreach ($students as $student): ?>
      <option value="<?= htmlspecialchars($student) ?>" <?= ($student === $studentFilter) ? 'selected' : '' ?>>
        <?= htmlspecialchars($student) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label for="subject">📘 Subject:</label>
  <select name="subject" id="subject">
    <option value="">All Subjects</option>
    <?php foreach ($subjects as $subject): ?>
      <option value="<?= htmlspecialchars($subject) ?>" <?= ($subject === $subjectFilter) ? 'selected' : '' ?>>
        <?= htmlspecialchars($subject) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <button class="btn" type="submit">🔍 Filter</button>
  <a href="index.php" class="btn">🔄 Reset</a>
</form>

<h2 style="text-align:center; margin-top: 50px;">➕ Add New Grade</h2>

<form method="post" action="addgrade.php" style="text-align: center; margin-bottom: 30px;">

  <input type="text" name="student" placeholder="👤 Full Name" required
         pattern="[A-Za-zĀ-žā-ž\s]{2,}" title="Only letters and spaces allowed">
         
  <input type="text" name="subject" placeholder="📘 Subject" required
         pattern="[A-Za-zĀ-žā-ž\s]{2,}" title="Only letters and spaces allowed">

  <input type="number" name="grade" placeholder="📝 Grade (1-10)" min="1" max="10" step="1" required>

  <button type="submit" class="btn">➕ Add Grade</button>

</form>


<table>
  <thead>
    <tr>
      <th>Student</th>
      <th>Subject</th>
      <th>Grade</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($grades) > 0): ?>
      <?php foreach ($grades as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['student_name']) ?></td>
          <td><?= htmlspecialchars($row['subject_name']) ?></td>
          <td><?= htmlspecialchars($row['grade']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="3" style="text-align:center;">No data found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>



</body>
</html>
