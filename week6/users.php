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
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, "SELECT * FROM users");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management - ElectroMart</title>
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
    .search-box { text-align: center; margin-bottom: 20px; }
    .search-box input {
        padding: 12px; border: none; border-radius: 8px; width: 300px;
        background: rgba(255, 255, 255, 0.1); color: #e0e0e0;
    }
    .search-box button {
        padding: 12px 20px; background: #00d4ff; color: #1a1a2e;
        border: none; border-radius: 8px; font-weight: bold; cursor: pointer;
    }
    .search-box button:hover { background: #00b4dc; }
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
    .badge-admin { background: #00d4ff; color: #1a1a2e; padding: 4px 10px; border-radius: 12px; font-size: 0.8em; font-weight: bold; }
    .badge-user { background: rgba(255, 255, 255, 0.15); color: #e0e0e0; padding: 4px 10px; border-radius: 12px; font-size: 0.8em; font-weight: bold; }
    .edit-link { color: #00d4ff; text-decoration: none; font-weight: bold; margin-right: 10px; }
    .edit-link:hover { text-decoration: underline; }
    .delete-link { color: #ff4d4d; text-decoration: none; font-weight: bold; }
    .delete-link:hover { text-decoration: underline; }
    .success-msg { color: #00ff88; font-weight: bold; text-align: center; margin-bottom: 15px; }
    .info-msg { color: #00d4ff; font-weight: bold; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>User Management</h1>
        <?php if(isset($_GET['updated'])) echo "<p class='info-msg'>User updated successfully!</p>"; ?>
        <?php if(isset($_GET['deleted'])) echo "<p class='success-msg'>User deleted successfully!</p>"; ?>
        <div class="search-box">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by username or email" value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Phone</th><th>Actions</th></tr>
            <?php while($u = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><span class="badge-<?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span></td>
                <td><?= htmlspecialchars($u['phone'] ?? '-') ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $u['id'] ?>" class="edit-link">Edit</a>
                    <a href="delete_user.php?id=<?= $u['id'] ?>" class="delete-link" onclick="return confirm('Delete user?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
