<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Fetch user info
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">iData GH</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="text-center mb-4">
      <h2>Welcome, <?= htmlspecialchars($user['username']) ?> 👋</h2>
      <p class="text-muted">Select a service below to continue.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-4 mb-3">
        <a href="order.php" class="btn btn-success w-100 py-3">Buy Data Bundle</a>
      </div>
      <div class="col-md-4 mb-3">
        <a href="order-history.php" class="btn btn-outline-primary w-100 py-3">Order History</a>
      </div>
    </div>
  </div>
</body>
</html>
