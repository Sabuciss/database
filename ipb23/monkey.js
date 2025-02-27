document.addEventListener("DOMContentLoaded", function () {
    let passwordField = document.getElementById("password");
    let monkey = document.querySelector(".monkey");

    passwordField.addEventListener("input", function () {
        if (passwordField.value.length > 0) {
            monkey.classList.add("cover");
        } else {
            monkey.classList.remove("cover");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let passwordField = document.getElementById("password");
    let togglePassword = document.getElementById("togglePassword");
    let monkey = document.querySelector(".monkey");

    togglePassword.addEventListener("click", function () {š
        if (passwordField.type === "password") {
            // Step 1: Monkey Peeks First
            monkey.classList.remove("cover");
            monkey.classList.add("peek");

            // Step 2: After slight delay, show password
            setTimeout(() => {
                passwordField.type = "text";
                togglePassword.textContent = "🔓"; // Change to open lock
            }, 300); // Delay to make peeking animation visible
        } else {
            // Step 1: Hide Password, Close Monkey's Eyes
            passwordField.type = "password";
            togglePassword.textContent = "👁️"; // Change to eye icon

            // Step 2: Monkey Covers Eyes Again
            monkey.classList.remove("peek");
            monkey.classList.add("cover");
        }
    });
});


