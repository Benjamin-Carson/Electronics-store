<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if(isset($_POST['confirm'])){
    $delete = "DELETE FROM products WHERE id=$id";
    if(mysqli_query($conn, $delete)){
        header("Location: products.php?deleted=1");
        exit();
    } else {
        $error = " Error deleting product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Product – ElectroMart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Delete Product</h1>

        <div class="card" style="width:50%; padding:30px;">
            <h2>Are you sure?</h2>
            <p>You are about to delete:</p>

            <strong> <?= $product['name'] ?></strong><br>
            <small>by <?= $product['brand'] ?></small><br>
            <small>Category: <?= $product['category'] ?> | Price: $<?= $product['price'] ?> | Stock: <?= $product['stock'] ?> | Rating:
                <?= $product['rating'] ?></small>

            <br><br>

            <form method="POST">
                <button type="submit" name="confirm" style="background:#d9534f;">Yes, Delete</button>
                <a href="products.php" class="btn" style="background:#6c757d;">Cancel</a>
            </form>

            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
    </div>
</body>

</html>
