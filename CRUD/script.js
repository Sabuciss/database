document.addEventListener('DOMContentLoaded', function () {
    // Get buttons and sections
    const createUserBtn = document.getElementById('createUserBtn');
    const readUserBtn = document.getElementById('readUserBtn');
    const createUserSection = document.getElementById('createUserSection');
    const readUserSection = document.getElementById('readUserSection');
    const editUserSection = document.getElementById('editUserSection');
    const userForm = document.getElementById('userForm');
    const saveUserBtn = document.getElementById('saveUserBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    // Toggle sections
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

    // Function to load users
    async function loadUsers() {
        let response = await fetch("read_users.php");
        let users = await response.json();

        let readSection = document.getElementById('readUserSection');
        readSection.innerHTML = "<h2>User List</h2>";

        if (users.length > 0) {
            let table = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            users.forEach(user => {
                table += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.first_name}</td>
                        <td>${user.last_name}</td>
                        <td>${user.tel}</td>
                        <td>${user.email}</td>
                        <td>
                            <a href="#" class="editBtn" data-id="${user.id}" data-firstname="${user.first_name}" data-lastname="${user.last_name}" data-phone="${user.tel}" data-email="${user.email}">Edit  </a> 
                            <a href="#" class="deleteBtn" data-id="${user.id}">Delete</a>
                        </td>
                    </tr>
                `;
            });

            table += `</tbody></table>`;
            readSection.innerHTML += table;
        } else {
            readSection.innerHTML += "<p>No users found.</p>";
        }

        addEditDeleteListeners();
    }

    // Function to add event listeners for edit and delete buttons
    function addEditDeleteListeners() {
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('editUserId').value = btn.getAttribute('data-id');
                document.getElementById('editFirstName').value = btn.getAttribute('data-firstname');
                document.getElementById('editLastName').value = btn.getAttribute('data-lastname');
                document.getElementById('editPhone').value = btn.getAttribute('data-phone');
                document.getElementById('editEmail').value = btn.getAttribute('data-email');
                editUserSection.style.display = 'block';
                readUserSection.style.display = 'none';
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                if (confirm("Are you sure you want to delete this user?")) {
                    let userId = btn.getAttribute('data-id');
                    let formData = new FormData();
                    formData.append("userId", userId);

                    let response = await fetch("delete_user.php", {
                        method: "POST",
                        body: formData
                    });

                    let result = await response.json();
                    alert(result.message);
                    loadUsers();
                }
            });
        });
    }

    // Handle the "Save" button click
    saveUserBtn.addEventListener('click', async function () {
        const userId = document.getElementById('editUserId').value;
        const firstName = document.getElementById('editFirstName').value;
        const lastName = document.getElementById('editLastName').value;
        const phone = document.getElementById('editPhone').value;
        const email = document.getElementById('editEmail').value;

        let formData = new FormData();
        formData.append("userId", userId);
        formData.append("firstName", firstName);
        formData.append("lastName", lastName);
        formData.append("phone", phone);
        formData.append("email", email);

        let response = await fetch("update_user.php", {
            method: "POST",
            body: formData
        });

        let result = await response.json();
        alert(result.message);
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';
        loadUsers();
    });

    // Handle "Cancel" button click
    cancelEditBtn.addEventListener('click', function () {
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';
    });

    // Load users initially
    loadUsers();
});
