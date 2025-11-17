<?php
// Configuration file
define('STORAGE_PATH', __DIR__ . '/storage/');
define('WEBSITES_FILE', STORAGE_PATH . 'websites.json');
define('HISTORY_FILE', STORAGE_PATH . 'history.json');

// Ensure storage directory exists
if (!is_dir(STORAGE_PATH)) {
    mkdir(STORAGE_PATH, 0755, true);
}

// Initialize files if they don't exist
if (!file_exists(WEBSITES_FILE)) {
    file_put_contents(WEBSITES_FILE, json_encode([]));
}
if (!file_exists(HISTORY_FILE)) {
    file_put_contents(HISTORY_FILE, json_encode([]));
}
?>