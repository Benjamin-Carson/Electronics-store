<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Products – ElectroMart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Products Catalog</h1>

        <div class="card-table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                </tr>

                <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['brand']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No products found</td></tr>";
            }
            ?>
            </table>
        </div>
    </div>

</body>

</html>
