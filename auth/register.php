<?php
session_start();
require_once '../config/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check passwords
    if ($password !== $confirm_password) {
        $message = "<div style='color:red;'>Passwords do not match.</div>";
    } else {

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([$username, $email, $hashed_password]);

            $message = "<div style='color:green;'>Account created successfully. <a href='login.php'>Login</a></div>";

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                $message = "<div style='color:red;'>Email already exists.</div>";
            } else {
                $message = "<div style='color:red;'>Something went wrong.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a1a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: #2d2d2d;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #404040;
        }

        .card h2 {
            text-align: center;
            color: #e8e8e8;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .card p {
            text-align: center;
            color: #b0b0b0;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #d0d0d0;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #404040;
            background: #3a3a3a;
            color: #e8e8e8;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input::placeholder {
            color: #808080;
        }

        input:focus {
            outline: none;
            border-color: #555555;
            box-shadow: 0 0 5px rgba(100, 100, 100, 0.3);
            background: #424242;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #444444;
            color: #e8e8e8;
            border: 1px solid #555555;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s, border-color 0.3s;
        }

        button:hover {
            background: #555555;
            border-color: #666666;
        }

        button:active {
            background: #3a3a3a;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #b0b0b0;
            font-size: 14px;
        }

        .login-link a {
            color: #a0a0a0;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #d0d0d0;
            text-decoration: underline;
        }

        .message {
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
        }

        .message a {
            color: inherit;
            font-weight: 600;
            text-decoration: none;
        }

        .error-message {
            background-color: #3a2626;
            color: #ff6b6b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #5a3636;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            background-color: #263a26;
            color: #6bff6b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #365a36;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Create Account</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            
            <button type="submit">Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>


