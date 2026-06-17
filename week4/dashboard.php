<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price * stock) AS revenue FROM products"))['revenue'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        display: flex;
        color: #e0e0e0;
        margin: 0;
        min-height: 100vh;
    }
    .main-content {
        flex: 1;
        padding: 30px;
        text-align: center;
    }
    h2 {
        color: #00d4ff;
        text-shadow: 0 0 10px rgba(0,212,255,0.3);
        margin-top: 0;
        font-size: 28px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 212, 255, 0.2);
    }
    .stat-card h3 {
        color: #00d4ff;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 10px 0;
    }
    .stat-card .value {
        font-size: 36px;
        font-weight: bold;
        color: #e0e0e0;
    }
    .stat-card .value.revenue {
        color: #28a745;
    }
    .welcome {
        font-size: 18px;
        color: #b0b0b0;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        <h2> Dashboard</h2>
        <div class="welcome">Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Products</h3>
                <div class="value"><?= $totalProducts ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value revenue">$<?= number_format($totalRevenue, 2) ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="value"><?= $totalUsers ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="value"><?= $totalOrders ?></div>
            </div>
        </div>
    </div>
</body>
</html>
