document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // Dynamic form updates based on trigger selection
    const triggerSelect = document.getElementById('trigger');
    const conditionsTextarea = document.getElementById('conditions');
    
    if (triggerSelect && conditionsTextarea) {
        triggerSelect.addEventListener('change', function() {
            const trigger = this.value;
            let placeholder = '';
            
            switch(trigger) {
                case 'weather_alert':
                    placeholder = '{"temp_above": 25, "city": "London"}';
                    break;
                case 'scheduled_email':
                    placeholder = '{"time": "09:00", "days": ["mon", "wed", "fri"]}';
                    break;
                case 'api_webhook':
                    placeholder = '{"url": "https://example.com/webhook", "method": "POST"}';
                    break;
                default:
                    placeholder = 'Enter conditions in JSON format';
            }
            
            conditionsTextarea.placeholder = placeholder;
        });
    }
});