<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Product not found.");
}

if(isset($_POST['confirm'])){
    if(mysqli_query($conn, "DELETE FROM products WHERE id=$id")){
        header("Location: improved_products.php?deleted=1");
        exit();
    } else {
        $error = "Error deleting product: " . mysqli_error($conn);
    }
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
    h1 { text-align: center; margin-bottom: 30px; font-weight: bold; color: #ff4d4d; }
    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        margin: 0 auto;
        text-align: center;
    }
    .card h2 { color: #ff4d4d; margin-bottom: 15px; }
    .card p { margin: 10px 0; color: #e0e0e0; }
    .card strong { color: #00d4ff; }
    .card small { color: #aaa; }
    button {
        padding: 12px 20px; background: #d9534f; color: #fff;
        border: none; border-radius: 8px; font-weight: bold; cursor: pointer;
        margin: 5px; transition: 0.3s;
    }
    button:hover { background: #c9302c; }
    a.cancel {
        display: inline-block; padding: 12px 20px; background: #6c757d;
        color: white; border-radius: 8px; text-decoration: none;
        font-weight: bold; margin: 5px; transition: 0.3s;
    }
    a.cancel:hover { background: #5a6268; }
    .error { color: #ff4d4d; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Delete Product</h1>
        <div class="card">
            <h2>Are you sure?</h2>
            <p>You are about to delete:</p>
            <strong><?= htmlspecialchars($product['name']) ?></strong><br>
            <small>by <?= htmlspecialchars($product['brand']) ?></small><br>
            <small>Category: <?= htmlspecialchars($product['category']) ?> | Price: $<?= $product['price'] ?> | Stock: <?= $product['stock'] ?> | Rating: <?= $product['rating'] ?></small>
            <br><br>
            <form method="POST">
                <button type="submit" name="confirm">Yes, Delete</button>
                <a href="improved_products.php" class="cancel">Cancel</a>
            </form>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        </div>
    </div>
</body>
</html>
