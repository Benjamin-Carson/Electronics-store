<div class="sidebar">
    <h2> ElectroMart</h2>

    <a href="dashboard.php" class="active"> Dashboard</a>
    <a href="products.php"> Products Catalog</a>
    <a href="add_product.php"> Add Product</a>
    <a href="reports.php"> Reports</a>
    <a href="logout.php"> Logout</a>
</div>

<style>
.sidebar {
    width: 220px;
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(10px);
    padding: 20px;
    box-shadow: 4px 0 12px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    gap: 15px;
    min-height: 100vh;
}

.sidebar h2 {
    text-align: center;
    color: #00d4ff;
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    padding: 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    color: #e0e0e0;
    background: rgba(255, 255, 255, 0.08);
    transition: 0.3s;
    text-align: center;
}

.sidebar a.active {
    background: rgba(0, 212, 255, 0.2);
    box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
}

.sidebar a:hover {
    background: rgba(0, 212, 255, 0.2);
}
</style>
