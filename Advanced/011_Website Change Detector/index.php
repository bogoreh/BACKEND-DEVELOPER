<?php
require_once 'config.php';

// Get existing websites
$websites = json_decode(file_get_contents(WEBSITES_FILE), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Change Detector</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🌐 Website Change Detector</h1>
            <p>Monitor websites for content changes</p>
        </header>

        <div class="main-content">
            <!-- Add Website Form -->
            <div class="card">
                <h2>Add Website to Monitor</h2>
                <form id="addWebsiteForm" class="website-form">
                    <div class="form-group">
                        <label for="websiteName">Website Name:</label>
                        <input type="text" id="websiteName" name="name" required placeholder="e.g., Google News">
                    </div>
                    <div class="form-group">
                        <label for="websiteUrl">Website URL:</label>
                        <input type="url" id="websiteUrl" name="url" required placeholder="https://example.com">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Website</button>
                </form>
            </div>

            <!-- Websites List -->
            <div class="card">
                <h2>Monitored Websites</h2>
                <div id="websitesList" class="websites-list">
                    <?php if (empty($websites)): ?>
                        <p class="no-websites">No websites added yet. Add your first website above!</p>
                    <?php else: ?>
                        <?php foreach ($websites as $index => $website): ?>
                            <div class="website-item" data-id="<?= $index ?>">
                                <div class="website-info">
                                    <h3><?= htmlspecialchars($website['name']) ?></h3>
                                    <a href="<?= htmlspecialchars($website['url']) ?>" target="_blank" class="website-url">
                                        <?= htmlspecialchars($website['url']) ?>
                                    </a>
                                    <div class="website-meta">
                                        <span class="last-checked">
                                            Last checked: <?= $website['last_checked'] ?? 'Never' ?>
                                        </span>
                                        <span class="status <?= $website['status'] ?? 'unknown' ?>">
                                            Status: <?= ucfirst($website['status'] ?? 'Unknown') ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="website-actions">
                                    <button class="btn btn-check" onclick="checkWebsite(<?= $index ?>)">
                                        Check Now
                                    </button>
                                    <button class="btn btn-delete" onclick="deleteWebsite(<?= $index ?>)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Check All Button -->
            <?php if (!empty($websites)): ?>
            <div class="card text-center">
                <button class="btn btn-large" onclick="checkAllWebsites()">
                    🔍 Check All Websites
                </button>
                <a href="history.php" class="btn btn-secondary">View History</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="modal">
        <div class="modal-content">
            <h3>Checking Websites...</h3>
            <div class="loading-spinner"></div>
            <p id="loadingMessage">Please wait while we check for changes</p>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>