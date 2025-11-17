<?php
require_once 'config.php';

$history = json_decode(file_get_contents(HISTORY_FILE), true) ?? [];
$websites = json_decode(file_get_contents(WEBSITES_FILE), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change History - Website Change Detector</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📋 Change History</h1>
            <p>History of detected website changes</p>
            <a href="index.php" class="btn btn-secondary">← Back to Monitor</a>
        </header>

        <div class="main-content">
            <div class="card">
                <?php if (empty($history)): ?>
                    <p class="no-history">No changes detected yet. Start monitoring websites to see changes here.</p>
                <?php else: ?>
                    <div class="history-list">
                        <?php foreach (array_reverse($history) as $entry): ?>
                            <div class="history-item">
                                <div class="history-icon">🔍</div>
                                <div class="history-details">
                                    <h3><?= htmlspecialchars($entry['website_name']) ?></h3>
                                    <p class="history-url"><?= htmlspecialchars($entry['website_url']) ?></p>
                                    <p class="history-timestamp"><?= $entry['timestamp'] ?></p>
                                </div>
                                <div class="history-type">
                                    <span class="change-badge">Change Detected</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>