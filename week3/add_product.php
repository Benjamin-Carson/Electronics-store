<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO products (name, brand, category, price, stock, rating) 
            VALUES ('$name', '$brand', '$category', '$price', '$stock', '$rating')";
    if(mysqli_query($conn, $sql)){
        header("Location: products.php?success=1");
        exit();
    } else {
        $error = " Error adding product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product – ElectroMart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Add New Product</h1>

        <form method="POST" class="form-card">
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

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>

</html>
