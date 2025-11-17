<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$users = getAllUsers($pdo);
$selected_user = null;

if (isset($_GET['user_id'])) {
    $selected_user_id = $_GET['user_id'];
    $selected_user = getUserById($pdo, $selected_user_id);
    
    // Mark messages as read
    $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ?");
    $stmt->execute([$_SESSION['user_id'], $selected_user_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>ChatApp</h3>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <div class="users-list">
                <h4>Online Users</h4>
                <?php foreach($users as $user): ?>
                    <div class="user-item <?php echo isset($selected_user) && $selected_user['id'] == $user['id'] ? 'active' : ''; ?>"
                         onclick="selectUser(<?php echo $user['id']; ?>)">
                        <div class="user-avatar"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></div>
                        <div class="user-details">
                            <span class="username"><?php echo $user['username']; ?></span>
                            <span class="status online">Online</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <?php if(isset($selected_user)): ?>
                <div class="chat-header">
                    <div class="chat-user-info">
                        <div class="user-avatar"><?php echo strtoupper(substr($selected_user['username'], 0, 1)); ?></div>
                        <div>
                            <h4><?php echo $selected_user['username']; ?></h4>
                            <span class="status online">Online</span>
                        </div>
                    </div>
                    <button class="video-call-btn" onclick="startVideoCall(<?php echo $selected_user['id']; ?>)">
                        📹 Video Call
                    </button>
                </div>

                <div class="messages-container" id="messagesContainer">
                    <!-- Messages will be loaded here -->
                </div>

                <div class="message-input">
                    <form id="messageForm" onsubmit="sendMessage(event)">
                        <input type="text" id="messageInput" placeholder="Type a message..." required>
                        <button type="submit">Send</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="welcome-screen">
                    <h2>Welcome to ChatApp</h2>
                    <p>Select a user to start chatting</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/chat.js"></script>
</body>
</html>