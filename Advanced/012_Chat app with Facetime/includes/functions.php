<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM users WHERE id != " . $_SESSION['user_id']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>