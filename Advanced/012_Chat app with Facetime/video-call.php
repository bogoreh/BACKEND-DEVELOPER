<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['room_id']) || !isset($_GET['user_id'])) {
    header('Location: chat.php');
    exit;
}

$room_id = $_GET['room_id'];
$receiver_id = $_GET['user_id'];
$receiver = getUserById($pdo, $receiver_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call - ChatApp</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="video-call-container">
        <div class="video-call-header">
            <h3>Video Call with <?php echo $receiver['username']; ?></h3>
            <div class="call-controls">
                <button id="muteBtn" onclick="toggleMute()">🎤 Mute</button>
                <button id="videoBtn" onclick="toggleVideo()">📹 Stop Video</button>
                <button id="endCallBtn" onclick="endCall()" class="end-call">📞 End Call</button>
            </div>
        </div>
        
        <div class="video-area">
            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
        </div>
        
        <div class="call-info">
            <p>Room ID: <?php echo $room_id; ?></p>
            <p id="callStatus">Connecting...</p>
        </div>
    </div>

    <script>
        const roomId = "<?php echo $room_id; ?>";
        const currentUserId = "<?php echo $_SESSION['user_id']; ?>";
    </script>
    <script src="assets/js/video-call.js"></script>
</body>
</html>