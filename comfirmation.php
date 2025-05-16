<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['order_id'])) {
  header("Location: dashboard.php");
  exit();
}

$order_id = $_GET['order_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
  echo "Order not found.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="text-center mb-4">Order Confirmation</h3>

        <ul class="list-group mb-4">
          <li class="list-group-item"><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></li>
          <li class="list-group-item"><strong>Network:</strong> <?= htmlspecialchars($order['network']) ?></li>
          <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></li>
          <li class="list-group-item"><strong>Amount:</strong> GHS <?= htmlspecialchars($order['amount']) ?></li>
          <li class="list-group-item"><strong>Bundle Type:</strong> <?= ucfirst(htmlspecialchars($order['bundle'])) ?></li>
        </ul>

        <div class="alert alert-warning">
          <h5>Next Step:</h5>
          Please send payment to the merchant number on the homepage and contact support via WhatsApp.<br>
          Mention your <strong>Order ID: <?= htmlspecialchars($order['order_id']) ?></strong>.
        </div>

        <div class="text-center">
          <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
