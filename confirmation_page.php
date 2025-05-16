<?php
// confirmation_page.php — Displays order summary
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $network = htmlspecialchars($_POST['network']);
  $phone = htmlspecialchars($_POST['phone']);
  $amount = htmlspecialchars($_POST['amount']);
  $bundle = htmlspecialchars($_POST['bundle']);
  $order_id = strtoupper(uniqid('ORD')); // Example Order ID
} else {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
    .container { max-width: 600px; margin: auto; background: white; padding: 2em; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { color: #003366; text-align: center; }
    .summary { margin-top: 2em; font-size: 1.1em; }
    .summary p { margin: 0.5em 0; }
    .note { margin-top: 2em; background: #fff3cd; padding: 1em; border-left: 5px solid #ffc107; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Order Confirmation</h2>
    <div class="summary">
      <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
      <p><strong>Network:</strong> <?php echo $network; ?></p>
      <p><strong>Phone:</strong> <?php echo $phone; ?></p>
      <p><strong>Amount:</strong> GHS <?php echo $amount; ?></p>
      <p><strong>Bundle:</strong> <?php echo ucfirst($bundle); ?></p>
    </div>

    <div class="note">
      <strong>Next Step:</strong> Your order is pending.
      Please send payment to the number shown on the homepage and contact admin via WhatsApp.
      Mention your Order ID <strong><?php echo $order_id; ?></strong>.
    </div>
  </div>
</body>
</html>
