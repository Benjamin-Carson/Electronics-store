<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])){
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'"))['id'];

    if($quantity < 1){
        $error = "Quantity must be at least 1.";
    } else {
        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$product_id"));

        if(!$product){
            $error = "Product not found.";
        } elseif($product['stock'] < $quantity){
            $error = "Insufficient stock. Available: " . $product['stock'];
        } else {
            mysqli_begin_transaction($conn);
            try {
                $total = $product['price'] * $quantity;
                mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, status) VALUES ($user_id, $total, 'pending')");
                $order_id = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, {$product['price']})");
                mysqli_query($conn, "UPDATE products SET stock = stock - $quantity WHERE id = $product_id");
                mysqli_commit($conn);
                $message = "Order placed successfully! Order #$order_id";
            } catch(Exception $e){
                mysqli_rollback($conn);
                $error = "Order failed: " . $e->getMessage();
            }
        }
    }
}

$orders_result = mysqli_query($conn, "SELECT o.id, u.username, o.total_amount, o.status, o.order_date FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");
$products_list = mysqli_query($conn, "SELECT id, name, price, stock FROM products WHERE stock > 0");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Orders - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        color: #e0e0e0;
        margin: 0;
        padding: 40px;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        width: 800px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #00d4ff;
        font-weight: bold;
    }

    select, input {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
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
        width: 95%;
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

    .message { color: #00ff88; font-weight: bold; margin: 10px 0; }
    .error { color: #ff4d4d; font-weight: bold; margin: 10px 0; }

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
        <h2>Place Order</h2>

        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <select name="product_id" required>
                <option value="">Select a product</option>
                <?php while($p = mysqli_fetch_assoc($products_list)){ ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> - $<?= $p['price'] ?> (Stock: <?= $p['stock'] ?>)</option>
                <?php } ?>
            </select>
            <input type="number" name="quantity" placeholder="Quantity" min="1" required>
            <button type="submit" name="place_order">Place Order</button>
        </form>

        <h2>Order History</h2>
        <table>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php if(mysqli_num_rows($orders_result) > 0){
                while($o = mysqli_fetch_assoc($orders_result)){ ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['username']) ?></td>
                <td>$<?= number_format($o['total_amount'], 2) ?></td>
                <td><?= $o['status'] ?></td>
                <td><?= $o['order_date'] ?></td>
            </tr>
            <?php } } else { ?>
            <tr><td colspan="5">No orders yet.</td></tr>
            <?php } ?>
        </table>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>
