// Add website form handler
document.getElementById('addWebsiteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const websiteData = {
        name: formData.get('name'),
        url: formData.get('url'),
        last_checked: 'Never',
        status: 'unknown'
    };
    
    // Add to local storage and update UI
    addWebsite(websiteData);
    this.reset();
});

function addWebsite(websiteData) {
    // In a real app, this would be an AJAX call to save to server
    // For now, we'll reload the page to show the updated list
    alert('Website added! In a full implementation, this would be saved to the server.');
    window.location.reload();
}

// Check single website
function checkWebsite(index) {
    showLoading('Checking website...');
    
    fetch('check.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ index: index })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showResult(data.result);
            // Reload to update the UI
            setTimeout(() => window.location.reload(), 2000);
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        hideLoading();
        alert('Error checking website: ' + error);
    });
}

// Check all websites
function checkAllWebsites() {
    showLoading('Checking all websites...');
    
    fetch('check.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ index: 'all' })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            let changedCount = data.results.filter(r => r.changed).length;
            let message = `Checked ${data.results.length} websites. `;
            message += changedCount > 0 ? 
                `Found changes in ${changedCount} website(s)!` : 
                'No changes detected.';
            alert(message);
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        hideLoading();
        alert('Error checking websites: ' + error);
    });
}

// Delete website
function deleteWebsite(index) {
    if (confirm('Are you sure you want to remove this website from monitoring?')) {
        // In a real app, this would be an AJAX call to delete from server
        alert('Website removed! In a full implementation, this would be deleted from the server.');
        window.location.reload();
    }
}

// Show result message
function showResult(result) {
    let message = `Checked: ${result.name}\n`;
    if (result.success) {
        if (result.changed) {
            message += '🔔 Changes detected!';
        } else {
            message += result.message || 'No changes detected.';
        }
    } else {
        message += `❌ Error: ${result.error}`;
    }
    alert(message);
}

// Loading modal functions
function showLoading(message = 'Loading...') {
    document.getElementById('loadingMessage').textContent = message;
    document.getElementById('loadingModal').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loadingModal').style.display = 'none';
}