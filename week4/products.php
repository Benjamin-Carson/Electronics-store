<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT id, name, brand FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products - ElectroMart</title>
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
    }
    table {
        margin: 20px auto;
        border-collapse: collapse;
        width: 80%;
        box-shadow: 0 0 15px rgba(0, 212, 255, 0.15);
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 12px;
        border: 1px solid rgba(0, 212, 255, 0.2);
    }
    th {
        background: rgba(0, 212, 255, 0.15);
        color: #00d4ff;
    }
    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.03);
    }
    a.back {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 20px;
        background: #00d4ff;
        color: #1a1a2e;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }
    a.back:hover {
        background: #00b4dc;
    }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        <h2> Products Catalog</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
            </tr>
            <?php } ?>
        </table>
        <a href="dashboard.php" class="back"> Back to Dashboard</a>
    </div>
</body>
</html>
