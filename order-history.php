<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Your Order History</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background-color: #003366; color: white; }
  </style>
</head>
<body>
  <h2>Your Orders</h2>
  <?php if ($orders): ?>
  <table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Network</th>
        <th>Phone</th>
        <th>Amount (GHS)</th>
        <th>Bundle</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
      <tr>
        <td><?= htmlspecialchars($order['order_id']) ?></td>
        <td><?= htmlspecialchars(ucfirst($order['network'])) ?></td>
        <td><?= htmlspecialchars($order['phone']) ?></td>
        <td><?= number_format($order['amount'], 2) ?></td>
        <td><?= htmlspecialchars(ucfirst($order['bundle'])) ?></td>
        <td><?= htmlspecialchars(ucfirst($order['status'])) ?></td>
        <td><?= htmlspecialchars($order['created_at']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p>You have no orders yet.</p>
  <?php endif; ?>
</body>
</html>
