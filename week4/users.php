<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] !== 'admin'){
    header("Location: dashboard.php");
    exit();
}

$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM users";
}
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Management - ElectroMart</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: #e0e0e0;
        text-align: center;
    }

    h2 {
        margin: 20px 0;
        color: #00d4ff;
        text-shadow: 0 0 10px rgba(0,212,255,0.3);
    }

    table {
        margin: 20px auto;
        border-collapse: collapse;
        width: 80%;
        box-shadow: 0 0 15px rgba(0, 212, 255, 0.15);
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        border: 1px solid rgba(0, 212, 255, 0.2);
    }

    th {
        background: rgba(0, 212, 255, 0.15);
        color: #00d4ff;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.03);
    }

    .badge-admin {
        background: #007bff;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .badge-user {
        background: #28a745;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .edit-btn, .delete-btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .edit-btn {
        background: #ffc107;
        color: #000;
    }

    .edit-btn:hover {
        background: #e0a800;
    }

    .delete-btn {
        background: #d9534f;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    .search-box {
        margin: 20px;
    }

    input[type=text] {
        padding: 8px;
        border-radius: 6px;
        border: none;
        width: 250px;
        background: rgba(255,255,255,0.1);
        color: #e0e0e0;
    }

    button {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        background: #00d4ff;
        color: #1a1a2e;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #00b4dc;
    }
    </style>
</head>

<body>
    <h2> User Management</h2>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search by username" value="<?= $search ?>">
        <button type="submit"> Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td>
                <?php if($row['role'] === 'admin'){ ?>
                <span class="badge-admin">Admin</span>
                <?php } else { ?>
                <span class="badge-user">User</span>
                <?php } ?>
            </td>
            <td>
                <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a>
                <a href="delete_user.php?id=<?= $row['id'] ?>" class="delete-btn"> Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="dashboard.php" style="color:#00d4ff;"> Back to Dashboard</a>
</body>

</html>
