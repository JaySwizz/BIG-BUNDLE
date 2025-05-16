<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $network = htmlspecialchars($_POST['network']);
  $phone = htmlspecialchars($_POST['phone']);
  $amount = htmlspecialchars($_POST['amount']);
  $bundle = htmlspecialchars($_POST['bundle']);
  $order_id = strtoupper(uniqid('ORD'));
  $user_id = $_SESSION['user_id'];

  $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_id, network, phone, amount, bundle) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$user_id, $order_id, $network, $phone, $amount, $bundle]);

  header("Location: confirmation.php?order_id=$order_id");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Bundle - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-4 text-center">Order Data Bundle</h3>
        <form method="POST">
          <div class="mb-3">
            <label for="network" class="form-label">Select Network</label>
            <select name="network" id="network" class="form-select" required>
              <option value="">-- Choose --</option>
              <option value="MTN">MTN</option>
              <option value="Vodafone">Vodafone</option>
              <option value="AirtelTigo">AirtelTigo</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Recipient Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="amount" class="form-label">Amount (GHS)</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="bundle" class="form-label">Bundle Type</label>
            <select name="bundle" id="bundle" class="form-select" required>
              <option value="">-- Choose --</option>
              <option value="daily">Daily</option>
              <option value="weekly">Weekly</option>
              <option value="monthly">Monthly</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary w-100">Place Order</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<form action="payment.php" method="POST" id="orderForm">
  <label for="network">Network:</label>
  <select name="network" id="network" required>
    <option value="">--Select Network--</option>
    <option value="mtn">MTN</option>
    <option value="vodafone">Vodafone</option>
    <option value="airtel">AirtelTigo</option>
  </select>

  <label for="phone">Phone Number:</label>
  <input type="tel" name="phone" id="phone" placeholder="e.g. 0244123456" required pattern="[0-9]{10}">

  <label for="bundle">Bundle:</label>
  <select name="bundle" id="bundle" required>
    <option value="">--Select Bundle--</option>
    <option value="daily">Daily</option>
    <option value="weekly">Weekly</option>
    <option value="monthly">Monthly</option>
  </select>

  <label for="amount">Amount (GHS):</label>
  <input type="number" name="amount" id="amount" min="1" step="0.01" required>

  <button type="submit">Order & Pay</button>
</form>
