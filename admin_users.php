<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch all users
$stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users - Admin - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Manage Users</h3>
    <a href="admin-dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <?php if (count($users) === 0): ?>
      <div class="alert alert-info">No users found.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Registered On</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= date('d M Y, H:i', strtotime($user['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
