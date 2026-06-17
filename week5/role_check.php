<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

function checkRole($requiredRole){
    if($_SESSION['role'] !== $requiredRole){
        ?>
<!DOCTYPE html>
<html>

<head>
    <title>Access Denied - ElectroMart</title>
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
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 420px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
        color: #ff4d4d;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 20px;
        background: #00d4ff;
        color: #1a1a2e;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a:hover {
        background: #00b4dc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2> Access Denied</h2>
        <p>You must be an <strong><?php echo ucfirst($requiredRole); ?></strong> to view this page.</p>
        <a href="dashboard.php"> Back to Dashboard</a>
    </div>
</body>

</html>
<?php
        exit();
    }
}
?>
