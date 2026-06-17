<?php
include("db_connect.php");
$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products – ElectroMart</title>
    <style>
    body { font-family: 'Segoe UI', sans-serif; background: #1a1a2e; color: #e0e0e0; padding: 40px; }
    h1 { color: #00d4ff; text-align: center; }
    table { width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.06); border-radius: 12px; overflow: hidden; }
    th, td { padding: 14px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.08); }
    th { background: rgba(0,212,255,0.15); color: #00d4ff; }
    </style>
</head>
<body>
    <h1>Products</h1>
    <table>
        <tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Stock</th></tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['brand'] ?></td>
            <td>$<?= $row['price'] ?></td>
            <td><?= $row['stock'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
