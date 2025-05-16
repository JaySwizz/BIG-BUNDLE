<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$reference = $_GET['reference'] ?? '';
$order_id = $_GET['order_id'] ?? '';

if (!$reference || !$order_id) {
    die('Invalid request.');
}

$paystack_secret_key = 'sk_test_6b714058049df2eee366087b2e96478731e5225b';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $paystack_secret_key"
    ],
));

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

if ($result['status'] && $result['data']['status'] === 'success' && $result['data']['reference'] === $reference) {
    // Update order status to paid
    $stmt = $pdo->prepare("UPDATE orders SET status = 'paid' WHERE order_id = ?");
    $stmt->execute([$order_id]);

    echo "<h3>Payment Successful!</h3>";
    echo "<p>Your order ID: <strong>$order_id</strong> has been paid.</p>";
    echo '<p><a href="dashboard.php">Go to Dashboard</a></p>';
} else {
    echo "<h3>Payment verification failed or incomplete.</h3>";
    echo '<p><a href="dashboard.php">Try again</a></p>';
}
