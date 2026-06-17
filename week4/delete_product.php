<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: improved_products.php?error=No+product+ID+specified");
    exit();
}

$id = intval($_GET['id']);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])){
    $sql = "DELETE FROM products WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: improved_products.php?success=Product+deleted+successfully");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);
if(!$product){
    header("Location: improved_products.php?error=Product+not+found");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Product - ElectroMart</title>
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
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h2 {
        color: #00d4ff;
        text-shadow: 0 0 10px rgba(0,212,255,0.3);
        margin-top: 0;
    }
    .confirm-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 450px;
        text-align: center;
    }
    .confirm-card p {
        font-size: 16px;
        margin: 8px 0;
    }
    .confirm-card .warning {
        color: #ffc107;
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 15px;
    }
    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;
    }
    .btn-group button, .btn-group a {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
    }
    .btn-delete {
        background: #d9534f;
        color: #fff;
    }
    .btn-delete:hover {
        background: #c9302c;
    }
    .btn-cancel {
        background: #6c757d;
        color: #fff;
    }
    .btn-cancel:hover {
        background: #5a6268;
    }
    .error {
        color: #ff4d4d;
        text-align: center;
        margin-top: 10px;
    }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        <h2> Confirm Deletion</h2>
        <div class="confirm-card">
            <div class="warning"> Are you sure you want to delete this product?</div>
            <p><strong>ID:</strong> <?= $product['id'] ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($product['name']) ?></p>
            <p><strong>Brand:</strong> <?= htmlspecialchars($product['brand']) ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
            <p><strong>Stock:</strong> <?= $product['stock'] ?></p>
            <p><strong>Rating:</strong> <?= $product['rating'] ?></p>

            <form method="POST" action="">
                <div class="btn-group">
                    <button type="submit" name="confirm" class="btn-delete"> Yes, Delete</button>
                    <a href="improved_products.php" class="btn-cancel"> Cancel</a>
                </div>
            </form>
            <?php if(isset($error)){ echo "<div class='error'>$error</div>"; } ?>
        </div>
    </div>
</body>
</html>
