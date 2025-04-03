document.addEventListener('DOMContentLoaded', function () {
    const editUserForm = document.getElementById('editUserForm');
    const editUserModal = document.getElementById('editUserModal');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    // Lietotāju tabulas ielāde
    async function loadUsers() {
        let response = await fetch('read.php');
        let users = await response.json();

        const userTable = document.getElementById('userTable');
        userTable.innerHTML = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vārds</th>
                    <th>Uzvārds</th>
                    <th>Dzimšanas datums</th>
                    <th>Telefons</th>
                    <th>E-pasts</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
        `;

        users.forEach(user => {
            userTable.innerHTML += `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.first_name}</td>
                    <td>${user.last_name}</td>
                    <td>${user.d_o_b}</td>
                    <td>${user.phone}</td>
                    <td>${user.email}</td>
                    <td>
                        <button class="editBtn" data-id="${user.id}" data-firstname="${user.first_name}" data-lastname="${user.last_name}" data-dob="${user.d_o_b}" data-phone="${user.phone}" data-email="${user.email}">✏ Rediģēt</button>
                        <button class="deleteBtn" data-id="${user.id}">❌ Dzēst</button>
                    </td>
                </tr>
            `;
        });

        userTable.innerHTML += `</tbody>`;
        addEditDeleteListeners();
    }

    // Pievieno klausītājus Edit un Delete pogām
    function addEditDeleteListeners() {
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                openEditModal({
                    id: btn.dataset.id,
                    first_name: btn.dataset.firstname,
                    last_name: btn.dataset.lastname,
                    d_o_b: btn.dataset.dob,
                    phone: btn.dataset.phone,
                    email: btn.dataset.email
                });
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                let userId = btn.dataset.id;
                if (confirm("Vai tiešām vēlaties dzēst šo lietotāju?")) {
                    deleteUser(userId);
                }
            });
        });
    }

    // Atver rediģēšanas popup logu
    function openEditModal(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editFirstName').value = user.first_name;
        document.getElementById('editastName').value = user.last_name;
        document.getElementById('editd_o_b').value = user.d_o_b;
        document.getElementById('editPhone').value = user.phone;
        document.getElementById('editEmail').value = user.email;

        editUserModal.style.display = 'block';
    }

    // Aizver modal logu
    closeModalBtn.addEventListener('click', function () {
        editUserModal.style.display = 'none';
    });

    cancelEditBtn.addEventListener('click', function () {
        editUserModal.style.display = 'none';
    });

    // Saglabā laboto lietotāju
    editUserForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const userData = {
            id: document.getElementById('editUserId').value,
            first_name: document.getElementById('editFirstName').value,
            last_name: document.getElementById('editLastName').value,
            d_o_b: document.getElementById('editD_o_b').value,
            phone: document.getElementById('editPhone').value,
            email: document.getElementById('editEmail').value
        };

        let response = await fetch('update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        });

        if (response.ok) {
            alert("Lietotājs veiksmīgi atjaunināts!");
            editUserModal.style.display = 'none';
            loadUsers(); // Atsvaidzina tabulu
        } else {
            alert("Neizdevās atjaunināt lietotāju.");
        }
    });

    // Dzēš lietotāju
    async function deleteUser(userId) {
        let response = await fetch(`delete.php?id=${userId}`, { method: 'DELETE' });
        if (response.ok) {
            alert("Lietotājs veiksmīgi izdzēsts!");
            loadUsers(); // Atsvaidzina tabulu
        } else {
            alert("Neizdevās izdzēst lietotāju.");
        }
    }

    // Ielādē lietotājus, kad lapa ielādējas
    loadUsers();
});
