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
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #e0e0e0;
        margin: 0;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 700px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
        color: #00d4ff;
    }

    .metric {
        margin: 10px 0;
        font-size: 18px;
    }

    .category {
        text-align: left;
        margin-top: 20px;
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
        transition: 0.3s;
    }

    a.back:hover {
        background: #00b4dc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2> Reports</h2>
        <div class="metric">Total Products: <?= $totalProducts ?></div>
        <div class="metric">Top Brand: <?= htmlspecialchars($mostBrand['brand']) ?>
            (<?= $mostBrand['count'] ?> products)</div>
        <div class="metric">Total Revenue: $<?= number_format($totalRevenue, 2) ?></div>
        <div class="metric">Top Rated Product: <?= htmlspecialchars($topProduct['name']) ?> ( <?= $topProduct['rating'] ?>)
        </div>
        <div class="metric">Low Stock Alerts: <?= $lowStock ?> products</div>

        <div class="category">
            <h3> Category Breakdown</h3>
            <?php while($c = mysqli_fetch_assoc($categories)){ ?>
            <div><?= htmlspecialchars($c['category']) ?>: <?= $c['count'] ?> products</div>
            <?php } ?>
        </div>

        <a href="dashboard.php" class="back"> Back to Dashboard</a>
    </div>
</body>

</html>
