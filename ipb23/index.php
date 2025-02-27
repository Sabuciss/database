<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="monkey.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form name="myForm" action="register.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <input type="text" name="first_name" required>
                <label>First Name</label>
            </div>
            <div class="input-group">
                <input type="text" name="last_name" required>
                <label>Last Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>

            <div class="password-container">
                <div class="monkey">
                    <div class="ears"></div>
                    <div class="face">
                        <div class="eyes">
                            <div class="eye left"></div>
                            <div class="eye right"></div>
                            <div class="hand left-hand"></div>
                            <div class="hand right-hand"></div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required>                                                                                                                                            
                    <label>Password</label>
                    <span class="toggle-password">
                        <i class="eye-icon" id="togglePassword">👁️</i>
                        <span class="tooltip">Can I take a peek?</span>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn">Register</button> 
        </form>
    </div>
    <script src="validator.js"></script>
    <script src="monkey.js"></script>
</body>
</html>
