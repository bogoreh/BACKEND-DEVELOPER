<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $receiver_id = $input['receiver_id'];
    $room_id = $input['room_id'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO video_calls (caller_id, receiver_id, room_id, status) VALUES (?, ?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $receiver_id, $room_id]);
        
        echo json_encode(['success' => true, 'room_id' => $room_id]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>