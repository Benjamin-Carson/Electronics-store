<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die(" No product ID provided.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $sql);

if(!$result || mysqli_num_rows($result) == 0){
    die(" Product not found.");
}

$product = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $rating = $_POST['rating'];

    $update = "UPDATE products 
               SET name='$name', brand='$brand', category='$category', 
                   price='$price', stock='$stock', rating='$rating' 
               WHERE id=$id";
    if(mysqli_query($conn, $update)){
        header("Location: improved_products.php?updated=1");
        exit();
    } else {
        $error = " Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product – ElectroMart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Edit Product</h1>

        <form method="POST" class="form-card">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Brand</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>

            <label>Category</label>
            <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>

            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

            <label>Stock</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

            <label>Rating</label>
            <input type="number" step="0.1" max="5" name="rating" value="<?= $product['rating'] ?>" required>

            <button type="submit">Update Product</button>
        </form>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>

</html>
