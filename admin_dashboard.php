<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch total users
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $stmt->fetchColumn();

// Fetch total orders
$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$total_orders = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4 text-center">Admin Dashboard</h3>

    <div class="row text-center mb-4">
      <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <p class="card-text display-4"><?= $total_users ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Total Orders</h5>
            <p class="card-text display-4"><?= $total_orders ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="admin-users.php" class="btn btn-outline-primary me-2">Manage Users</a>
      <a href="admin-orders.php" class="btn btn-outline-success">Manage Orders</a>
    </div>

    <div class="text-center mt-4">
      <a href="admin-logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</body>
</html>
