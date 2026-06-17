<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Improved Products – ElectroMart</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .low-stock {
        background: rgba(255, 193, 7, 0.1);
        backdrop-filter: blur(6px);
        color: #ffc107;
        font-weight: bold;
        border-left: 4px solid #ffc107;
    }

    .success-msg {
        color: #00ff88;
        font-weight: bold;
    }

    .info-msg {
        color: #00d4ff;
        font-weight: bold;
    }

    .delete-btn {
        color: #fff;
        background: #d9534f;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    .edit-btn {
        color: #fff;
        background: #007bff;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .edit-btn:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Improved Products View</h1>

        <?php if(isset($_GET['deleted'])): ?>
        <p class="success-msg"> Product deleted successfully!</p>
        <?php elseif(isset($_GET['updated'])): ?>
        <p class="info-msg"> Product updated successfully!</p>
        <?php elseif(isset($_GET['success'])): ?>
        <p class="success-msg"> Product added successfully!</p>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr class="<?= ($row['stock'] < 10 ? 'low-stock' : '') ?>">
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['brand'] ?></td>
                <td><?= $row['category'] ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['rating'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="delete-btn"> Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <p style="margin-top:15px; font-weight:bold;">Page 1 of 1 · <?= mysqli_num_rows($result) ?> results</p>
    </div>
</body>

</html>
