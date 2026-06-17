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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $rating = floatval($_POST['rating']);

    $sql = "UPDATE products SET name='$name', brand='$brand', category='$category',
            price=$price, stock=$stock, rating=$rating WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: improved_products.php?success=Product+updated+successfully");
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
    <title>Edit Product - ElectroMart</title>
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
    .form-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 400px;
    }
    .form-card input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
        background: rgba(255,255,255,0.1);
        color: #e0e0e0;
        box-sizing: border-box;
    }
    .form-card button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background: #00d4ff;
        font-weight: bold;
        cursor: pointer;
        color: #1a1a2e;
        margin-top: 10px;
    }
    .form-card button:hover {
        background: #00b4dc;
    }
    .error {
        color: #ff4d4d;
        text-align: center;
        margin-top: 10px;
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
        <h2> Edit Product (ID: <?= $product['id'] ?>)</h2>
        <div class="form-card">
            <form method="POST" action="">
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
                <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
                <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
                <input type="number" step="0.1" name="rating" value="<?= $product['rating'] ?>" required>
                <button type="submit"> Update Product</button>
            </form>
            <?php if(isset($error)){ echo "<div class='error'>$error</div>"; } ?>
        </div>
        <a href="improved_products.php" class="back"> Back to Products</a>
    </div>
</body>
</html>
