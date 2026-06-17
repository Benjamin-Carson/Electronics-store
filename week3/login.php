<?php
session_start();
include("db_connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){
            $_SESSION['user'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = " Invalid password!";
        }
    } else {
        $error = " User not found!";
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
    }

    .login-box {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
        width: 300px;
    }

    h2 {
        margin-bottom: 20px;
        color: #00d4ff;
        text-align: center;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
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
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2> Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="error"><?php if(isset($error)) echo $error; ?></div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
