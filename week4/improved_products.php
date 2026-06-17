<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Improved Products - ElectroMart</title>
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
        width: 95%;
        box-shadow: 0 0 15px rgba(0, 212, 255, 0.15);
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 10px;
        border: 1px solid rgba(0, 212, 255, 0.2);
    }
    th {
        background: rgba(0, 212, 255, 0.15);
        color: #00d4ff;
    }
    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.03);
    }
    .low-stock {
        background: rgba(255, 193, 7, 0.25);
        color: #ffc107;
        font-weight: bold;
    }
    .edit-btn, .delete-btn {
        padding: 5px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9em;
    }
    .edit-btn {
        background: #ffc107;
        color: #000;
    }
    .edit-btn:hover {
        background: #e0a800;
    }
    .delete-btn {
        background: #d9534f;
        color: #fff;
    }
    .delete-btn:hover {
        background: #c9302c;
    }
    .banner {
        padding: 12px;
        border-radius: 8px;
        margin: 15px auto;
        width: 80%;
        font-weight: bold;
    }
    .banner.success {
        background: rgba(40, 167, 69, 0.3);
        color: #28a745;
        border: 1px solid #28a745;
    }
    .banner.error {
        background: rgba(217, 83, 79, 0.3);
        color: #d9534f;
        border: 1px solid #d9534f;
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
        <h2> Products Management</h2>

        <?php if(isset($_GET['success'])){ ?>
        <div class="banner success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php } ?>
        <?php if(isset($_GET['error'])){ ?>
        <div class="banner error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php } ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr class="<?= $row['stock'] < 10 ? 'low-stock' : '' ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['rating'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="delete-btn"> Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="dashboard.php" class="back"> Back to Dashboard</a>
    </div>
</body>
</html>
