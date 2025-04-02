function editUser(id, firstName, lastName, phone, email, dob) {
    // Iestata vērtības formā
    document.getElementById("editUserId").value = id;
    document.getElementById("editFirstName").value = firstName;
    document.getElementById("editLastName").value = lastName;
    document.getElementById("editPhone").value = phone;
    document.getElementById("editEmail").value = email;
    document.getElementById("editd_o_b").value = dob;  // Pievienots dzimšanas datums

    // Parāda rediģēšanas formu
    document.getElementById("editUserSection").style.display = "block";
}

// Atcelt rediģēšanu
document.getElementById("cancelEditBtn").addEventListener("click", function() {
    document.getElementById("editUserSection").style.display = "none";
});


// Dzēšanas funkcija
function deleteUser(event, userId) {
    event.preventDefault(); // Novērš formu no standarta nosūtīšanas

    if (confirm("Vai tiešām vēlaties dzēst šo lietotāju?")) {
        // Izveido AJAX pieprasījumu
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    // Pārsūta atpakaļ uz lietotāju sarakstu un parāda alert
                    alert("Lietotājs veiksmīgi dzēsts.");
                    location.reload(); // Atsvaidzina lapu
                } else {
                    alert("Radās kļūda dzēšot lietotāju.");
                }
            }
        };
        xhr.send("user_id=" + userId);
    }
}
