document.getElementById('userForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(this); // Get all form data

    try {
        const response = await fetch('create.php', {
            method: 'POST',
            body: formData, // Send data to the server
        });

        const result = await response.json(); // Get the response
        alert(result.message); // Show success message
        this.reset(); // Reset the form after successful submission
    } catch (error) {
        console.error('Error:', error);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const createUserBtn = document.getElementById('createUserBtn');
    const readUserBtn = document.getElementById('readUserBtn');
    const createUserSection = document.getElementById('createUserSection');
    const readUserSection = document.getElementById('readUserSection');
    const editUserSection = document.getElementById('editUserSection');
    const saveUserBtn = document.getElementById('saveUserBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    if (createUserBtn && readUserBtn) {
        createUserBtn.addEventListener('click', () => {
            createUserSection.style.display = 'block';
            readUserSection.style.display = 'none';
            editUserSection.style.display = 'none';
        });

        readUserBtn.addEventListener('click', () => {
            createUserSection.style.display = 'none';
            readUserSection.style.display = 'block';
            editUserSection.style.display = 'none';
            loadUsers();
        });
    }

    async function loadUsers() {
        let response = await fetch("read.php");
        let users = await response.json();

        let readSection = document.getElementById('readUserSection');
        readSection.innerHTML = "<h2>User List</h2>";

        if (users.length > 0) {
            let table = `<table><thead><tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Actions</th>
                        </tr></thead><tbody>`;
            
            users.forEach(user => {
                table += `<tr>
                            <td>${user.id}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.phone}</td>
                            <td>${user.email}</td>
                            <td>${user.d_o_b}</td>
                            <td>
                                <button class="editBtn" data-id="${user.id}" data-firstname="${user.first_name}" data-lastname="${user.last_name}" data-phone="${user.phone}" data-email="${user.email}" data-d_o_b="${user.d_o_b}">Edit</button>
                                <button class="deleteBtn" data-id="${user.id}">Delete</button>
                            </td>
                        </tr>`;
            });
            table += `</tbody></table>`;
            readSection.innerHTML += table;
        } else {
            readSection.innerHTML += "<p>No users found.</p>";
        }

        addEditDeleteListeners();
    }

    function addEditDeleteListeners() {
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('editUserId').value = btn.getAttribute('data-id');
                document.getElementById('editFirstName').value = btn.getAttribute('data-firstname');
                document.getElementById('editLastName').value = btn.getAttribute('data-lastname');
                document.getElementById('editPhone').value = btn.getAttribute('data-phone');
                document.getElementById('editEmail').value = btn.getAttribute('data-email');
                document.getElementById('editd_o_b').value = btn.getAttribute('data-d_o_b');
                editUserSection.style.display = 'block';
                readUserSection.style.display = 'none';
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                if (confirm("Are you sure you want to delete this user?")) {
                    let formData = new FormData();
                    formData.append("userId", btn.getAttribute('data-id'));
                    let response = await fetch("delete.php", { method: "POST", body: formData });
                    let result = await response.json();
                    alert(result.message);
                    loadUsers();
                }
            });
        });
    }

    saveUserBtn.addEventListener('click', async function () {
        const formData = new FormData(document.getElementById('editUserForm'));
        let response = await fetch("update.php", { method: "POST", body: formData });
        let result = await response.json();
        alert(result.message);
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';
        loadUsers();
    });

    cancelEditBtn.addEventListener('click', function () {
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';
    });

    loadUsers();
});
