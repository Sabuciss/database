<?php
require 'config.php'; // Iekļauj datubāzes savienojumu

$sql = "SELECT * FROM users";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lietotāju saraksts</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <h2>Lietotāju saraksts</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>E-pasts</th>
                <th>Telefons</th>
                <th>Dzimšanas datums</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= htmlspecialchars($user['d_o_b']) ?></td> <!-- Dzimšanas datums -->
                    <td>
                        <button onclick='editUser(<?= $user['id'] ?>, "<?= $user['first_name'] ?>", "<?= $user['last_name'] ?>", "<?= $user['phone'] ?>", "<?= $user['email'] ?>", "<?= $user['d_o_b'] ?>")'>✏ Rediģēt</button>

                        <form method="POST" id="deleteForm<?= $user['id'] ?>" style="display:inline;" onsubmit="deleteUser(event, <?= $user['id'] ?>)">
                            <button type="submit">❌ Dzēst</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
