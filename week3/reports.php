<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$mostBrand = mysqli_fetch_assoc(mysqli_query($conn, "SELECT brand, COUNT(*) AS count FROM products GROUP BY brand ORDER BY count DESC LIMIT 1"));
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price * stock) AS revenue FROM products"))['revenue'];
$topProduct = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, rating FROM products ORDER BY rating DESC LIMIT 1"));
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS low FROM products WHERE stock < 5"))['low'];
$categories = mysqli_query($conn, "SELECT category, COUNT(*) AS count FROM products GROUP BY category");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reports - ElectroMart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1 class="page-title"> Reports</h1>
        <div class="card" style="width:60%; padding:30px;">
            <p>Total Products: <?= $totalProducts ?></p>
            <p>Top Brand: <?= htmlspecialchars($mostBrand['brand']) ?> (<?= $mostBrand['count'] ?> products)</p>
            <p>Total Revenue: $<?= number_format($totalRevenue, 2) ?></p>
            <p>Top Rated: <?= htmlspecialchars($topProduct['name']) ?> (<?= $topProduct['rating'] ?>)</p>
            <p>Low Stock: <?= $lowStock ?> products</p>
            <h3>Category Breakdown</h3>
            <?php while($c = mysqli_fetch_assoc($categories)){ ?>
            <p><?= htmlspecialchars($c['category']) ?>: <?= $c['count'] ?> products</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>
