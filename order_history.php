<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order History - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4 text-center">Your Order History</h3>

    <?php if (count($orders) === 0): ?>
      <div class="alert alert-info text-center">You have no orders yet.</div>
      <div class="text-center">
        <a href="order.php" class="btn btn-success">Place Your First Order</a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-primary">
            <tr>
              <th>Order ID</th>
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
      <div class="text-center mt-3">
        <a href="dashboard.php" class="btn btn-outline-primary">Back to Dashboard</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
