<?php
include 'db.php';

$result = $conn->query("SELECT * FROM transactions");

echo "<h2>Transactions</h2><table border='1'><tr><th>ID</th><th>Network</th><th>Data</th><th>Phone</th><th>Amount</th><th>Status</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['network']}</td><td>{$row['data_plan']}</td><td>{$row['phone']}</td><td>{$row['amount']}</td><td>{$row['status']}</td></tr>";
}
echo "</table>";
?>
