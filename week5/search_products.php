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
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #e0e0e0;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 600px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #00d4ff;
        font-weight: bold;
    }

    input {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 80%;
        background: rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
    }

    button {
        padding: 12px 20px;
        background: #00d4ff;
        color: #1a1a2e;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #00b4dc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: left;
        color: #e0e0e0;
    }

    th {
        background: rgba(0, 212, 255, 0.15);
        font-weight: bold;
        color: #00d4ff;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.03);
    }

    a {
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

    a:hover {
        background: #00b4dc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2> Search Products</h2>
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Enter product name or brand">
            <button type="submit">Search</button>
        </form>

        <?php if(!empty($results) && $results->num_rows > 0){ ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Brand</th>
            </tr>
            <?php while($row = $results->fetch_assoc()){ ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['brand']); ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } elseif($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <p> No products found matching your search.</p>
        <?php } ?>

        <a href="dashboard.php"> Back to Dashboard</a>
    </div>
</body>

</html>
