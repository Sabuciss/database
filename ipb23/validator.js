function validateForm() {
    var firstName = document.forms["myForm"]["first_name"].value;
    var lastName = document.forms["myForm"]["last_name"].value;
    var email = document.forms["myForm"]["email"].value;
    var password = document.forms["myForm"]["password"].value;

    // Regex tikai latviešu burtiem ar mīkstinājuma un garumzīmēm
    var nameRegex = /^[A-Za-zĀāČčĒēĢģĪīĶķĻļŅņÓóŠšŪūŽž]+$/;
    
    if (!nameRegex.test(firstName)) {
        alert("Vārds jābūt tikai ar latviešu burtiem.");
        return false;
    }
    
    if (!nameRegex.test(lastName)) {
        alert("Uzvārds jābūt tikai ar latviešu burtiem.");
        return false;
    }

    var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
        alert("Ievadi pareizu epasta formātu.");
        return false;
    }

    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/;
    if (!passwordRegex.test(password)) {
        alert("Parolei jābūt vismaz 9 rakstzīmēm, tai jāietver cipars, simbols, mazais un lielais burts.");
        return false;
    }

    return true; 
}
