<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products - ElectroMart</title>
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
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border-radius: 12px;
        overflow: hidden;
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
        <h1>Products Catalog</h1>
        <table>
            <tr><th>ID</th><th>Name</th><th>Brand</th><th>Category</th><th>Price</th><th>Stock</th><th>Rating</th></tr>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['rating'] ?></td>
            </tr>
            <?php } ?>
        </table>
        <p style="margin-top:15px; font-weight:bold;">Total: <?= mysqli_num_rows($result) ?> products</p>
    </div>
</body>
</html>
