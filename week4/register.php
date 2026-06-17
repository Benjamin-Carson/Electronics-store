<?php
include("db_connect.php");
session_start();

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone'] ?? '');

    // Validation
    if(empty($username) || empty($email) || empty($password)){
        $error = "All fields are required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format.";
    } elseif(strlen($password) < 6){
        $error = "Password must be at least 6 characters.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        if($check->get_result()->num_rows > 0){
            $error = "Username or email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, phone) VALUES (?, ?, ?, 'user', ?)");
            $stmt->bind_param("ssss", $username, $email, $hash, $phone);
            if($stmt->execute()){
                $success = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #e0e0e0;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 350px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #00d4ff;
        font-weight: bold;
    }

    input {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        background: rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
    }

    input::placeholder { color: #888; }

    button {
        padding: 12px 20px;
        background: #00d4ff;
        color: #1a1a2e;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        width: 95%;
    }

    button:hover { background: #00b4dc; }

    .error { color: #ff4d4d; margin-top: 10px; font-weight: bold; }
    .success { color: #00ff88; margin-top: 10px; font-weight: bold; }

    .links { margin-top: 15px; }
    .links a { color: #00d4ff; text-decoration: none; font-weight: bold; }
    .links a:hover { text-decoration: underline; }
    </style>
</head>

<body>
    <div class="card">
        <h2> Register</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone" placeholder="Phone (optional)"><br>
            <input type="password" name="password" placeholder="Password (min 6 chars)" required><br>
            <button type="submit">Register</button>
        </form>
        <div class="links">
            <a href="login.php"> Back to Login</a>
        </div>
    </div>
</body>

</html>
