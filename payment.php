<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Sanitize POST data
$network = htmlspecialchars($_POST['network']);
$phone = htmlspecialchars($_POST['phone']);
$amount = htmlspecialchars($_POST['amount']);
$bundle = htmlspecialchars($_POST['bundle']);
$user_id = $_SESSION['user_id'];
$order_id = strtoupper(uniqid('ORD'));

// Save order as pending
$stmt = $pdo->prepare("INSERT INTO orders (user_id, order_id, network, phone, amount, bundle, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $order_id, $network, $phone, $amount, $bundle, 'pending']);

$paystack_public_key = 'pk_test_5fee2c675d8a48ffe178fc37ddfff1d83fd8f265';
$paystack_email = $_SESSION['email'] ?? 'user@example.com';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Pay for Your Order - iData GH</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
    <h3>Pay Now for Order ID: <?= $order_id ?></h3>
    <p>Amount: GHS <?= number_format($amount, 2) ?></p>

    <button type="button" onclick="payWithPaystack()">Pay Now</button>

    <script>
        function payWithPaystack(){
            var handler = PaystackPop.setup({
                key: '<?= $paystack_public_key ?>',
                email: '<?= $paystack_email ?>',
                amount: <?= $amount * 100 ?>, // amount in kobo
                currency: "GHS",
                ref: '<?= $order_id ?>', // unique transaction reference
                callback: function(response){
                    // Payment complete, verify on server
                    window.location.href = 'verify-payment.php?reference=' + response.reference + '&order_id=<?= $order_id ?>';
                },
                onClose: function(){
                    alert('Payment cancelled.');
                    window.location.href = 'dashboard.php';
                }
            });
            handler.openIframe();
        }
    </script>
</body>
</html>
