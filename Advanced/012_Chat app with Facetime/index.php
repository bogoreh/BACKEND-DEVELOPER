<?php
require_once 'includes/functions.php';
if (isLoggedIn()) {
    header('Location: chat.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>