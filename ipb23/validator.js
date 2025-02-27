function validateForm() {
    var firstName = document.forms["myForm"]["first_name"].value;
    var lastName = document.forms["myForm"]["last_name"].value;
    var email = document.forms["myForm"]["email"].value;
    var password = document.forms["myForm"]["password"].value;

    var nameRegex = /^[A-Za-z]+$/;
    if (!nameRegex.test(firstName)) {
        alert("Jāsatur tikai burtus.");
        return false;
    }
    if (!nameRegex.test(lastName)) {
        alert("Jāsatur tikai burtus");
        return false;
    }

    var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
        alert("Ievadi normālu epastu.");
        return false;
    }

    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/;
    if (!passwordRegex.test(password)) {
        alert("Minimālais paroles garums 9, iekļaut simbolu, ciparu, mazo un lielo burtu.");
        return false;
    }

    return true; // Form validation passed, allow form submission
}
