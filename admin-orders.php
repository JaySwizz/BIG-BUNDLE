<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch all orders with user info
$stmt = $pdo->query("
    SELECT orders.*, users.username 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    ORDER BY orders.created_at DESC
");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Orders - Admin - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Manage Orders</h3>
    <a href="admin-dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <?php if (count($orders) === 0): ?>
      <div class="alert alert-info">No orders found.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-primary">
            <tr>
              <th>Order ID</th>
              <th>User</th>
              <th>Network</th>
              <th>Phone</th>
              <th>Amount (GHS)</th>
              <th>Bundle</th>
              <th>Ordered On</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?= htmlspecialchars($order['order_id']) ?></td>
                <td><?= htmlspecialchars($order['username']) ?></td>
                <td><?= htmlspecialchars($order['network']) ?></td>
                <td><?= htmlspecialchars($order['phone']) ?></td>
                <td><?= htmlspecialchars($order['amount']) ?></td>
                <td><?= ucfirst(htmlspecialchars($order['bundle'])) ?></td>
                <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
