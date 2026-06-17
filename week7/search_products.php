<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST['search']);
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR brand LIKE ?");
        $like = "%$search%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $results = $stmt->get_result();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Products - ElectroMart</title>
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
    .search-box { text-align: center; margin-bottom: 20px; }
    .search-box input {
        padding: 12px; border: none; border-radius: 8px; width: 300px;
        background: rgba(255, 255, 255, 0.1); color: #e0e0e0;
    }
    .search-box button {
        padding: 12px 20px; background: #00d4ff; color: #1a1a2e;
        border: none; border-radius: 8px; font-weight: bold; cursor: pointer;
    }
    .search-box button:hover { background: #00b4dc; }
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
    p.no-results { text-align: center; color: #aaa; margin-top: 20px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Search Products</h1>
        <div class="search-box">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Enter product name or brand">
                <button type="submit">Search</button>
            </form>
        </div>
        <?php if(!empty($results) && $results->num_rows > 0){ ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Brand</th><th>Category</th><th>Price</th><th>Stock</th><th>Rating</th></tr>
            <?php while($row = $results->fetch_assoc()){ ?>
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
        <?php } elseif($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <p class="no-results">No products found matching your search.</p>
        <?php } ?>
    </div>
</body>
</html>
