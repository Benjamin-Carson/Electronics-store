<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $rating = floatval($_POST['rating']);

    $stmt = $conn->prepare("INSERT INTO products (name, brand, category, price, stock, rating) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssidi", $name, $brand, $category, $price, $stock, $rating);
    if($stmt->execute()){
        header("Location: improved_products.php?success=1");
        exit();
    } else {
        $error = "Error adding product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product - ElectroMart</title>
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
    form {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        margin: 0 auto;
    }
    label { display: block; margin-top: 15px; font-weight: bold; color: #00d4ff; }
    input {
        width: 100%; padding: 12px; margin: 5px 0;
        border: none; border-radius: 8px;
        background: rgba(255, 255, 255, 0.1); color: #e0e0e0;
        box-sizing: border-box;
    }
    button {
        width: 100%; padding: 12px; margin-top: 20px;
        background: #00d4ff; color: #1a1a2e; border: none;
        border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;
    }
    button:hover { background: #00b4dc; }
    .error { color: #ff4d4d; text-align: center; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Add New Product</h1>
        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Brand</label>
            <input type="text" name="brand" required>
            <label>Category</label>
            <input type="text" name="category" required>
            <label>Price</label>
            <input type="number" step="0.01" name="price" required>
            <label>Stock</label>
            <input type="number" name="stock" required>
            <label>Rating</label>
            <input type="number" step="0.1" max="5" name="rating" required>
            <button type="submit">Add Product</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
