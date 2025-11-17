let localStream;
let peerConnection;
const configuration = {
    iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
};

// Initialize video call
async function initVideoCall() {
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ 
            video: true, 
            audio: true 
        });
        document.getElementById('localVideo').srcObject = localStream;
        
        // In a real app, you'd use WebRTC with signaling server
        // This is a simplified version
        document.getElementById('callStatus').textContent = 'Call in progress';
        
    } catch (error) {
        console.error('Error accessing media devices:', error);
        document.getElementById('callStatus').textContent = 'Error accessing camera/microphone';
    }
}

function toggleMute() {
    if (localStream) {
        const audioTrack = localStream.getAudioTracks()[0];
        audioTrack.enabled = !audioTrack.enabled;
        document.getElementById('muteBtn').textContent = 
            audioTrack.enabled ? '🎤 Mute' : '🎤 Unmute';
    }
}

function toggleVideo() {
    if (localStream) {
        const videoTrack = localStream.getVideoTracks()[0];
        videoTrack.enabled = !videoTrack.enabled;
        document.getElementById('videoBtn').textContent = 
            videoTrack.enabled ? '📹 Stop Video' : '📹 Start Video';
    }
}

function endCall() {
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
    }
    if (peerConnection) {
        peerConnection.close();
    }
    window.close();
}

// Initialize when page loads
window.addEventListener('load', initVideoCall);

// Handle page unload
window.addEventListener('beforeunload', endCall);