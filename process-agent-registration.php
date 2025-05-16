<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$stmt = $conn->prepare("INSERT INTO agents (name, email, phone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $phone);
$stmt->execute();

echo "Thanks $name, your agent registration is received.";
?>
