```php
<?php

session_start();

require_once "config/database.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Check if email already exists
    $check = $conn->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->bind_param("s", $email);
    $check->execute();

    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {

        $message = "Email already registered.";
        $message_type = "error";

    } else {

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $role = "student";

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password, role)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $hashed_password,
            $role
        );

        if ($stmt->execute()) {

            $message = "Registration successful! You can now login.";
            $message_type = "success";

        } else {

            $message = "Registration failed. Please try again.";
            $message_type = "error";
        }

        $stmt->close();
    }

    $check->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - College Event Management</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
        }

        .navbar {
            background: #0d6efd;
            color: white;
            padding: 18px 40px;
        }

        .navbar h2 {
            margin: 0;
        }

        .container {
            min-height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .register-box {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .register-box h1 {
            text-align: center;
            color: #0d6efd;
            margin-top: 0;
        }

        .register-box p {
            text-align: center;
            color: #666;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .register-btn {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #198754;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .register-btn:hover {
            background: #157347;
        }

        .message {
            padding: 12px;
            border-radius: 6px;
            margin-top: 20px;
            text-align: center;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .error {
            background: #f8d7da;
            color: #842029;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .home-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
        }

    </style>

</head>

<body>

    <div class="navbar">

        <h2>🎓 College Event Management</h2>

    </div>


    <div class="container">

        <div class="register-box">

            <h1>Create Account</h1>

            <p>Register as a student</p>


            <?php if ($message != ""): ?>

                <div class="message <?= htmlspecialchars($message_type) ?>">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    required
                >


                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >


                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >


                <button
                    type="submit"
                    class="register-btn">
                    Create Account
                </button>

            </form>


            <div class="login-link">

                Already have an account?

                <a href="login.php">
                    Login
                </a>

            </div>


            <a href="index.php" class="home-link">
                ← Back to Home
            </a>

        </div>

    </div>

</body>

</html>
```
