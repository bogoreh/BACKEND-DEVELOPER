<?php
include 'config.php';

$id = $_GET['id'];

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit();
?>