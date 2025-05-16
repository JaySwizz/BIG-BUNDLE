<?php
session_start();
require_once 'db.php';

// Load PHPMailer manually
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

  // Check if email already exists
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if ($stmt->rowCount() > 0) {
    $error = "Email already registered.";
  } else {
    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    // Send confirmation email
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'jayswizz253@gmail.com';
      $mail->Password = 'qfjgjludqqkakthx'; // Your App Password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('jayswizz253@gmail.com', 'iData GH');
      $mail->addAddress($email, $username);
      $mail->isHTML(true);
      $mail->Subject = "Welcome to iData GH!";
      $mail->Body = "
        <h2>Hello, $username</h2>
        <p>Thank you for registering with <strong>iData GH</strong>.</p>
        <p>You can now log in and start ordering bundles.</p>
      ";

      $mail->send();
      $success = "Registration successful! Please check your email.";
    } catch (Exception $e) {
      $error = "Registration successful, but email failed to send. Error: {$mail->ErrorInfo}";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - iData GH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="text-center mb-4">Register</h3>
            <?php if (isset($error)): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif (isset($success)): ?>
              <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" required class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" required class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-control">
              </div>
              <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <div class="text-center mt-3">
              <small>Already have an account? <a href="login.php">Login</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
