    <?php if (!isset($hideFooter) || !$hideFooter): ?>
    <footer style="
        background: var(--dark-color);
        color: var(--white);
        padding: 40px 0 20px;
        margin-top: auto;
    ">
        <div class="container">
            <div style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 30px;
                margin-bottom: 30px;
            ">
                <div class="footer-section">
                    <h4 style="color: var(--primary-color); margin-bottom: 15px;">ChatApp</h4>
                    <p style="color: #bdc3c7; line-height: 1.6;">
                        Connect with your friends and colleagues through seamless messaging and video calls. 
                        Simple, fast, and reliable communication.
                    </p>
                </div>
                
                <div class="footer-section">
                    <h4 style="color: var(--primary-color); margin-bottom: 15px;">Quick Links</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 8px;">
                            <a href="chat.php" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">Home</a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">Features</a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">Terms of Service</a>
                        </li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4 style="color: var(--primary-color); margin-bottom: 15px;">Contact</h4>
                    <div style="color: #bdc3c7;">
                        <p style="margin-bottom: 8px;">📧 support@chatapp.com</p>
                        <p style="margin-bottom: 8px;">📞 +1 (555) 123-4567</p>
                        <p style="margin-bottom: 8px;">📍 123 Chat Street, Digital City</p>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4 style="color: var(--primary-color); margin-bottom: 15px;">Follow Us</h4>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="
                            color: #bdc3c7;
                            text-decoration: none;
                            transition: color 0.3s;
                            font-size: 18px;
                        ">📘</a>
                        <a href="#" style="
                            color: #bdc3c7;
                            text-decoration: none;
                            transition: color 0.3s;
                            font-size: 18px;
                        ">🐦</a>
                        <a href="#" style="
                            color: #bdc3c7;
                            text-decoration: none;
                            transition: color 0.3s;
                            font-size: 18px;
                        ">📷</a>
                        <a href="#" style="
                            color: #bdc3c7;
                            text-decoration: none;
                            transition: color 0.3s;
                            font-size: 18px;
                        ">💼</a>
                    </div>
                </div>
            </div>
            
            <div style="
                border-top: 1px solid #34495e;
                padding-top: 20px;
                text-align: center;
                color: #bdc3c7;
                font-size: 14px;
            ">
                <p>&copy; <?php echo date('Y'); ?> ChatApp. All rights reserved. | Made with ❤️ for better communication</p>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Global JavaScript -->
    <script>
        // Utility functions
        function formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInHours = (now - date) / (1000 * 60 * 60);
            
            if (diffInHours < 24) {
                return date.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: true 
                });
            } else {
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        }
        
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        // Auto-scroll to bottom of element
        function scrollToBottom(element) {
            if (element) {
                element.scrollTop = element.scrollHeight;
            }
        }
        
        // Escape HTML to prevent XSS
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
        
        // Check if user is logged in
        function checkAuth() {
            <?php if (!isset($_SESSION['user_id'])): ?>
                showNotification('Please log in to continue', 'warning');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
        
        // Handle connection status
        let isOnline = true;
        
        window.addEventListener('online', () => {
            isOnline = true;
            showNotification('Connection restored', 'success', 3000);
        });
        
        window.addEventListener('offline', () => {
            isOnline = false;
            showNotification('You are offline', 'error', 0);
        });
        
        // Page load animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to main content
            const mainContent = document.querySelector('main') || document.body;
            mainContent.style.opacity = '0';
            mainContent.style.transition = 'opacity 0.3s ease';
            
            setTimeout(() => {
                mainContent.style.opacity = '1';
            }, 100);
            
            // Add loading states to buttons
            document.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON' || e.target.type === 'submit') {
                    const button = e.target;
                    const originalText = button.innerHTML;
                    
                    // Only show loading for buttons that trigger actions
                    if (!button.classList.contains('no-loading')) {
                        button.innerHTML = '<span class="loading-spinner"></span> Loading...';
                        button.disabled = true;
                        
                        // Revert after 5 seconds if still loading
                        setTimeout(() => {
                            if (button.disabled) {
                                button.innerHTML = originalText;
                                button.disabled = false;
                                showNotification('Request timed out. Please try again.', 'error');
                            }
                        }, 5000);
                    }
                }
            });
        });
        
        // Error handling
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            showNotification('Something went wrong. Please refresh the page.', 'error');
        });
        
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>