<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(price * stock), 0) AS revenue FROM products"))['revenue'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS low FROM products WHERE stock < 5"))['low'];

$topProducts = mysqli_query($conn, "SELECT name, rating, brand FROM products ORDER BY rating DESC LIMIT 5");
$recentOrders = mysqli_query($conn, "SELECT o.id, u.username, o.total_amount, o.status FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - ElectroMart</title>
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
        display: block;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        color: #e0e0e0;
        background: rgba(255, 255, 255, 0.08);
        transition: 0.3s;
        text-align: center;
    }

    .sidebar a:hover { background: rgba(0, 212, 255, 0.2); }

    .main {
        flex: 1;
        padding: 40px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
        color: #00d4ff;
    }

    .stats {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 200px;
        text-align: center;
        font-weight: bold;
        color: #00d4ff;
    }

    .charts {
        display: flex;
        gap: 40px;
        justify-content: center;
        margin-top: 40px;
    }

    .chart {
        flex: 1;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    canvas { width: 100% !important; height: 300px !important; }

    .section { margin-top: 40px; }

    .section h2 { text-align: center; margin-bottom: 20px; color: #00d4ff; }

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    th, td {
        padding: 14px;
        text-align: left;
        color: #e0e0e0;
    }

    th {
        background: rgba(0, 212, 255, 0.15);
        font-weight: bold;
        color: #00d4ff;
    }

    tr:nth-child(even) { background: rgba(255, 255, 255, 0.03); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="improved_products.php">Products Catalog</a>
        <a href="add_product.php">Add Product</a>
        <a href="search_products.php">Search Products</a>
        <a href="orders.php">Orders</a>
        <a href="ratings.php">Ratings</a>
        <a href="reports.php">Reports</a>
        <a href="users.php">User Management</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h1>Dashboard Overview</h1>

        <div class="stats">
            <div class="stat-card"><?= $totalProducts ?><br>Total Products</div>
            <div class="stat-card">$<?= number_format($totalRevenue, 2) ?><br>Total Revenue</div>
            <div class="stat-card"><?= $totalUsers ?><br>Active Users</div>
            <div class="stat-card"><?= $lowStock ?><br>Low Stock Items</div>
        </div>

        <div class="charts">
            <div class="chart">
                <h3>Revenue Overview</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart">
                <h3>Products by Category</h3>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="section">
            <h2>Top Rated Products</h2>
            <table>
                <tr><th>Name</th><th>Brand</th><th>Rating</th></tr>
                <?php while($p = mysqli_fetch_assoc($topProducts)){ ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['brand']) ?></td>
                    <td><?= $p['rating'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="section">
            <h2>Recent Orders</h2>
            <table>
                <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th></tr>
                <?php while($o = mysqli_fetch_assoc($recentOrders)){ ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['username']) ?></td>
                    <td>$<?= number_format($o['total_amount'], 2) ?></td>
                    <td><?= $o['status'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [32000, 35000, 37000, 40000, 45000, <?= $totalRevenue ?>],
                borderColor: '#00d4ff',
                backgroundColor: 'rgba(0,212,255,0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: [
                <?php
                $catLabels = [];
                $catCounts = [];
                $categories = mysqli_query($conn, "SELECT category, COUNT(*) AS count FROM products GROUP BY category");
                while($c = mysqli_fetch_assoc($categories)){
                    $catLabels[] = "'" . $c['category'] . "'";
                    $catCounts[] = $c['count'];
                }
                echo implode(",", $catLabels);
                ?>
            ],
            datasets: [{
                label: 'Products',
                data: [<?= implode(",", $catCounts) ?>],
                backgroundColor: ['#00d4ff', '#007bff', '#ffc107', '#ff4d4d', '#00ff88', '#9933ff']
            }]
        }
    });
    </script>
</body>

</html>
