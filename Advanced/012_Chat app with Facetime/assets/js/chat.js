let selectedUserId = null;
let pollInterval = null;

function selectUser(userId) {
    selectedUserId = userId;
    window.location.href = `chat.php?user_id=${userId}`;
}

function loadMessages() {
    if (!selectedUserId) return;
    
    fetch(`api/get_messages.php?receiver_id=${selectedUserId}`)
        .then(response => response.json())
        .then(messages => {
            const container = document.getElementById('messagesContainer');
            container.innerHTML = '';
            
            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${message.sender_id == selectedUserId ? 'received' : 'sent'}`;
                messageDiv.innerHTML = `
                    <div class="message-content">${message.message}</div>
                    <div class="message-time">${message.created_at}</div>
                `;
                container.appendChild(messageDiv);
            });
            
            container.scrollTop = container.scrollHeight;
        });
}

function sendMessage(event) {
    event.preventDefault();
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (!message || !selectedUserId) return;
    
    fetch('api/send_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            receiver_id: selectedUserId,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            loadMessages();
        }
    });
}

function startVideoCall(receiverId) {
    const roomId = 'room_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    fetch('api/start_video_call.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            receiver_id: receiverId,
            room_id: roomId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.open(`video-call.php?room_id=${roomId}&user_id=${receiverId}`, '_blank', 'width=800,height=600');
        }
    });
}

// Poll for new messages
if (selectedUserId) {
    loadMessages();
    pollInterval = setInterval(loadMessages, 2000);
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (pollInterval) {
        clearInterval(pollInterval);
    }
});