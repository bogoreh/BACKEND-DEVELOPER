<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'ChatApp'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --text-dark: #2d3748;
            --text-light: #718096;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background: var(--success-color);
        }
        
        .notification.error {
            background: var(--danger-color);
        }
        
        .notification.info {
            background: var(--info-color);
        }
        
        .notification.warning {
            background: var(--warning-color);
        }
        
        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mt-4 { margin-top: 2rem; }
        
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 2rem; }
        
        .hidden { display: none; }
        .flex { display: flex; }
        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .notification {
                left: 15px;
                right: 15px;
                transform: translateY(-100px);
            }
            
            .notification.show {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Notification Container -->
    <div id="notificationContainer"></div>
    
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Online Status Indicator -->
    <div class="online-indicator" style="
        position: fixed;
        top: 10px;
        left: 10px;
        background: var(--success-color);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        z-index: 999;
        display: flex;
        align-items: center;
        gap: 5px;
    ">
        <span class="status-dot" style="
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        "></span>
        Online
    </div>
    
    <style>
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
    <?php endif; ?>

    <script>
        // Notification System
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        cursor: pointer;
                        font-size: 16px;
                        margin-left: 10px;
                    ">×</button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Trigger animation
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Auto remove
            if (duration > 0) {
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                }, duration);
            }
        }
        
        // Handle PHP messages
        <?php if (isset($_SESSION['message'])): ?>
            showNotification('<?php echo $_SESSION['message']['text']; ?>', '<?php echo $_SESSION['message']['type']; ?>');
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        // Online status check
        function updateOnlineStatus() {
            // In a real app, you'd ping the server here
            const indicator = document.querySelector('.online-indicator');
            if (indicator) {
                // Simulate occasional status updates
                if (Math.random() < 0.1) { // 10% chance
                    indicator.style.background = '#f39c12';
                    indicator.innerHTML = '<span class="status-dot"></span>Connecting...';
                    setTimeout(() => {
                        indicator.style.background = '#27ae60';
                        indicator.innerHTML = '<span class="status-dot"></span>Online';
                    }, 1000);
                }
            }
        }
        
        // Update online status every 30 seconds
        setInterval(updateOnlineStatus, 30000);
        
        // Handle page visibility changes
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateOnlineStatus();
            }
        });
    </script>