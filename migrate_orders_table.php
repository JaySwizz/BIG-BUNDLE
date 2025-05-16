<?php
require_once 'db.php'; // your PDO connection

try {
    $sql = "
    ALTER TABLE orders
    ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
    ";
    $pdo->exec($sql);
    echo "Database updated successfully.";
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?>
