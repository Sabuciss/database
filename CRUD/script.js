document.addEventListener('DOMContentLoaded', function () {
    // Get buttons and sections
    const createUserBtn = document.getElementById('createUserBtn');
    const readUserBtn = document.getElementById('readUserBtn');
    const createUserSection = document.getElementById('createUserSection');
    const readUserSection = document.getElementById('readUserSection');
    const editUserSection = document.getElementById('editUserSection'); // Edit user section
    const userForm = document.getElementById('userForm'); // The create user form
    const saveUserBtn = document.getElementById('saveUserBtn'); // Save button for editing
    const cancelEditBtn = document.getElementById('cancelEditBtn'); // Cancel button for editing
    
    // Toggle sections when menu items are clicked
    if (createUserBtn && readUserBtn && createUserSection && readUserSection && editUserSection) {
        createUserBtn.addEventListener('click', () => {
            createUserSection.style.display = 'block';
            readUserSection.style.display = 'none';
            editUserSection.style.display = 'none'; // Hide edit section
        });

        readUserBtn.addEventListener('click', () => {
            createUserSection.style.display = 'none';
            readUserSection.style.display = 'block';
            editUserSection.style.display = 'none'; // Hide edit section
        });
    }

    // Handle Create User form submission
    userForm.addEventListener('submit', async function (e) {
        e.preventDefault();  // Prevent normal form submission

        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const formData = new FormData();
        formData.append("firstName", firstName);
        formData.append("lastName", lastName);
        formData.append("phone", phone);
        formData.append("email", email);
        formData.append("password", password);

        try {
            // Sending the data to PHP script using fetch API (AJAX)
            const response = await fetch("create_user.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();
            alert(result.message); // Show success or error message

            if (result.status === "success") {
                // Optionally reset the form or update the UI
                userForm.reset();
                readUserBtn.click(); // Refresh user list
            }
        } catch (error) {
            console.error("Error creating user:", error);
        }
    });

    // Show users and allow editing
    readUserBtn.addEventListener('click', async function () {
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
                            <th>Action</th>
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
                        <td><a href="#" class="editBtn" data-id="${user.id}" data-firstname="${user.first_name}" data-lastname="${user.last_name}" data-phone="${user.tel}" data-email="${user.email}">Edit</a></td>
                    </tr>
                `;
            });

            table += `</tbody></table>`;
            readSection.innerHTML += table;
        } else {
            readSection.innerHTML += "<p>No users found.</p>";
        }

        document.getElementById('createUserSection').style.display = 'none';
        readSection.style.display = 'block';

        // Add event listeners for the "Edit" buttons
        const editBtns = document.querySelectorAll('.editBtn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                // Get the user data from the button's data attributes
                const userId = btn.getAttribute('data-id');
                const firstName = btn.getAttribute('data-firstname');
                const lastName = btn.getAttribute('data-lastname');
                const phone = btn.getAttribute('data-phone');
                const email = btn.getAttribute('data-email');

                // Populate the edit form with user data
                document.getElementById('editUserId').value = userId;
                document.getElementById('editFirstName').value = firstName;
                document.getElementById('editLastName').value = lastName;
                document.getElementById('editPhone').value = phone;
                document.getElementById('editEmail').value = email;

                // Show the edit section
                editUserSection.style.display = 'block';
                readUserSection.style.display = 'none';

                // Add a class to the body to dim the background
                document.body.classList.add('editing');
            });
        });
    });

    // Handle the "Save" button click for updating user information
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

        // Refresh the user list
        readUserBtn.click();

        // Hide the edit section
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';

        // Remove the dimmed background
        document.body.classList.remove('editing');
    });

    // Handle the "Cancel" button click to close the edit section without saving
    cancelEditBtn.addEventListener('click', function () {
        editUserSection.style.display = 'none';
        readUserSection.style.display = 'block';
        document.body.classList.remove('editing');
    });
});
