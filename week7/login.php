<?php
session_start();
include("db_connect.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        $error = "Please enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['user'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        color: #e0e0e0;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
        width: 300px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #00d4ff;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
        box-sizing: border-box;
        background: rgba(255,255,255,0.1);
        color: #e0e0e0;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background: #00d4ff;
        font-weight: bold;
        cursor: pointer;
        color: #1a1a2e;
    }

    button:hover {
        background: #00b4dc;
    }

    .error {
        color: #ff4d4d;
        font-size: 0.9em;
        margin-top: 5px;
    }

    a {
        color: #00d4ff;
        display: block;
        margin-top: 12px;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Create an account</a>
    </div>
</body>

</html>
