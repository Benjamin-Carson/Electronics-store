<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";
$user_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'"))['id'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_rating'])){
    $product_id = intval($_POST['product_id']);
    $rating = floatval($_POST['rating']);
    $review = trim($_POST['review']);

    if($rating < 1 || $rating > 5){
        $error = "Rating must be between 1 and 5.";
    } else {
        $stmt = $conn->prepare("INSERT INTO ratings (product_id, user_id, rating, review) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE rating=VALUES(rating), review=VALUES(review)");
        $stmt->bind_param("iids", $product_id, $user_id, $rating, $review);
        if($stmt->execute()){
            $avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg FROM ratings WHERE product_id=$product_id"))['avg'];
            mysqli_query($conn, "UPDATE products SET rating=$avg WHERE id=$product_id");
            $message = "Rating submitted!";
        } else {
            $error = "Error submitting rating.";
        }
    }
}

$ratings_result = mysqli_query($conn, "SELECT r.id, p.name AS product_name, u.username, r.rating, r.review, r.created_at FROM ratings r JOIN products p ON r.product_id = p.id JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$products_list = mysqli_query($conn, "SELECT id, name FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ratings - ElectroMart</title>
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
    h2 { margin-bottom: 20px; color: #00d4ff; font-weight: bold; }
    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        margin: 0 auto 30px;
        text-align: center;
    }
    select, input, textarea {
        padding: 12px; margin: 10px 0; border: none; border-radius: 8px; width: 90%;
        background: rgba(255, 255, 255, 0.1); color: #e0e0e0;
    }
    textarea { resize: vertical; }
    button {
        padding: 12px 20px; background: #00d4ff; color: #1a1a2e;
        border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; width: 95%;
    }
    button:hover { background: #00b4dc; }
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }
    th, td { padding: 14px; text-align: left; color: #e0e0e0; }
    th { background: rgba(0, 212, 255, 0.15); font-weight: bold; color: #00d4ff; }
    tr:nth-child(even) { background: rgba(255, 255, 255, 0.03); }
    .message { color: #00ff88; font-weight: bold; margin: 10px 0; }
    .error { color: #ff4d4d; font-weight: bold; margin: 10px 0; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Ratings</h1>
        <div class="card">
            <h2>Rate a Product</h2>
            <?php if($message) echo "<p class='message'>$message</p>"; ?>
            <?php if($error) echo "<p class='error'>$error</p>"; ?>
            <form method="POST" action="">
                <select name="product_id" required>
                    <option value="">Select a product</option>
                    <?php while($p = mysqli_fetch_assoc($products_list)){ ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php } ?>
                </select>
                <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" step="0.1" required>
                <textarea name="review" placeholder="Write a review (optional)" rows="3"></textarea>
                <button type="submit" name="submit_rating">Submit Rating</button>
            </form>
        </div>
        <div class="card">
            <h2>All Ratings</h2>
            <table>
                <tr><th>Product</th><th>User</th><th>Rating</th><th>Review</th><th>Date</th></tr>
                <?php if(mysqli_num_rows($ratings_result) > 0){
                    while($r = mysqli_fetch_assoc($ratings_result)){ ?>
                <tr>
                    <td><?= htmlspecialchars($r['product_name']) ?></td>
                    <td><?= htmlspecialchars($r['username']) ?></td>
                    <td><?= $r['rating'] ?></td>
                    <td><?= htmlspecialchars($r['review'] ?: '-') ?></td>
                    <td><?= $r['created_at'] ?></td>
                </tr>
                <?php } } else { ?>
                <tr><td colspan="5">No ratings yet.</td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
