<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$topBrand = mysqli_fetch_assoc(mysqli_query($conn, "SELECT brand, COUNT(*) AS cnt FROM products GROUP BY brand ORDER BY cnt DESC LIMIT 1"));
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(price * stock), 0) AS revenue FROM products"))['revenue'];
$topProduct = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, rating FROM products ORDER BY rating DESC LIMIT 1"));
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS low FROM products WHERE stock < 10"))['low'];
$categories = mysqli_query($conn, "SELECT category, COUNT(*) AS count FROM products GROUP BY category");
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];
$totalRevenueOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount), 0) AS revenue FROM orders"))['revenue'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        margin: 0;
        padding: 0;
        color: #e0e0e0;
        display: flex;
    }
    .sidebar {
        width: 220px;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        padding: 20px;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-height: 100vh;
    }
    .sidebar a {
        display: block; padding: 12px; border-radius: 8px;
        text-decoration: none; font-weight: bold; color: #e0e0e0;
        background: rgba(255, 255, 255, 0.08); transition: 0.3s; text-align: center;
    }
    .sidebar a:hover { background: rgba(0, 212, 255, 0.2); }
    .main { flex: 1; padding: 40px; }
    h1 { text-align: center; margin-bottom: 30px; font-weight: bold; color: #00d4ff; }
    .stats { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 40px; }
    .stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 20px; border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 200px; text-align: center; font-weight: bold; color: #00d4ff;
    }
    .section { margin-top: 40px; }
    .section h2 { text-align: center; margin-bottom: 20px; color: #00d4ff; }
    table {
        width: 100%; max-width: 500px; margin: 0 auto;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border-radius: 12px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }
    th, td { padding: 14px; text-align: left; color: #e0e0e0; }
    th { background: rgba(0, 212, 255, 0.15); font-weight: bold; color: #00d4ff; }
    tr:nth-child(even) { background: rgba(255, 255, 255, 0.03); }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Business Reports</h1>
        <div class="stats">
            <div class="stat-card"><?= $totalProducts ?><br>Total Products</div>
            <div class="stat-card"><?= $totalUsers ?><br>Total Users</div>
            <div class="stat-card"><?= $totalOrders ?><br>Total Orders</div>
            <div class="stat-card">$<?= number_format($revenue, 2) ?><br>Inventory Value</div>
            <div class="stat-card">$<?= number_format($totalRevenueOrders, 2) ?><br>Order Revenue</div>
            <div class="stat-card"><?= $topBrand ? $topBrand['brand'] : 'N/A' ?><br>Top Brand</div>
            <div class="stat-card"><?= $topProduct ? htmlspecialchars($topProduct['name']) . ' (' . $topProduct['rating'] . ')' : 'N/A' ?><br>Top Product</div>
            <div class="stat-card"><?= $lowStock ?><br>Low Stock Items</div>
        </div>
        <div class="section">
            <h2>Category Breakdown</h2>
            <table>
                <tr><th>Category</th><th>Count</th></tr>
                <?php while($c = mysqli_fetch_assoc($categories)){ ?>
                <tr><td><?= htmlspecialchars($c['category']) ?></td><td><?= $c['count'] ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
