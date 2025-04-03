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
</head>
<body>

<nav>
    <ul>
        <li><a href="index.html">Reģistrējies</a></li>
        <li><a href="upload.html">Failu augšupielāde</a></li>
    </ul>
</nav>

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
                <td><?= htmlspecialchars($user['d_o_b']) ?></td>
                <td>
                    <button onclick='editUser(<?= $user['id'] ?>, "<?= $user['first_name'] ?>", "<?= $user['last_name'] ?>", "<?= $user['phone'] ?>", "<?= $user['email'] ?>", "<?= $user['d_o_b'] ?>")'> Rediģēt</button>

                    <form method="POST" action="delete.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button type="submit"> Dzēst</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <h2>Rediģēt lietotāju</h2>
        <form id="editUserForm" method="POST" action="update.php">
            <input type="hidden" id="editUserId" name="id">
            <label for="editFirstName">Vārds:</label>
            <input type="text" id="editFirstName" name="first_name" required>

            <label for="editLastName">Uzvārds:</label>
            <input type="text" id="editLastName" name="last_name" required>

            <label for="editD_o_b">Dzimšanas datums:</label>
            <input type="date" id="editD_o_b" name="d_o_b" required>

            <label for="editPhone">Telefons:</label>
            <input type="text" id="editPhone" name="phone" required>

            <label for="editEmail">E-pasts:</label>
            <input type="email" id="editEmail" name="email" required>

            <button type="submit">Saglabāt</button>
            <button type="button" id="cancelEditBtn">Atcelt</button>
        </form>
    </div>
</div>

<script>
    // Funkcija, lai atvērtu modālo logu ar lietotāja datiem
    function editUser(id, firstName, lastName, phone, email, d_o_b) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editEmail').value = email;
        document.getElementById('editD_o_b').value = d_o_b;

        document.getElementById('editUserModal').style.display = 'block';
    }

    // Funkcija, lai aizvērtu modālo logu
    document.getElementById('closeModal').onclick = function () {
        document.getElementById('editUserModal').style.display = 'none';
    }

    // Atcelt pogas darbība
    document.getElementById('cancelEditBtn').onclick = function () {
        document.getElementById('editUserModal').style.display = 'none';
    }
</script>

</body>
</html>
