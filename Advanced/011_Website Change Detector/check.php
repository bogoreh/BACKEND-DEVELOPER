<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $websiteIndex = $input['index'] ?? null;
    
    $websites = json_decode(file_get_contents(WEBSITES_FILE), true) ?? [];
    $history = json_decode(file_get_contents(HISTORY_FILE), true) ?? [];
    
    if ($websiteIndex === 'all') {
        // Check all websites
        $results = [];
        foreach ($websites as $index => $website) {
            $result = checkSingleWebsite($website, $index, $websites, $history);
            $results[] = $result;
        }
        echo json_encode(['success' => true, 'results' => $results]);
    } elseif (isset($websites[$websiteIndex])) {
        // Check single website
        $result = checkSingleWebsite($websites[$websiteIndex], $websiteIndex, $websites, $history);
        echo json_encode(['success' => true, 'result' => $result]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Website not found']);
    }
}

function checkSingleWebsite($website, $index, &$websites, &$history) {
    $url = $website['url'];
    $currentContent = @file_get_contents($url);
    $currentHash = $currentContent ? md5($currentContent) : null;
    
    $result = [
        'index' => $index,
        'name' => $website['name'],
        'url' => $website['url'],
        'success' => false,
        'changed' => false,
        'error' => null
    ];
    
    if ($currentContent === false) {
        $result['error'] = 'Failed to fetch website content';
        $websites[$index]['status'] = 'error';
    } else {
        $result['success'] = true;
        $previousHash = $websites[$index]['last_hash'] ?? null;
        
        if ($previousHash && $previousHash !== $currentHash) {
            $result['changed'] = true;
            $websites[$index]['status'] = 'changed';
            
            // Add to history
            $history[] = [
                'website_index' => $index,
                'website_name' => $website['name'],
                'website_url' => $website['url'],
                'timestamp' => date('Y-m-d H:i:s'),
                'type' => 'change_detected'
            ];
        } elseif (!$previousHash) {
            $websites[$index]['status'] = 'unchanged';
            $result['message'] = 'First check completed';
        } else {
            $websites[$index]['status'] = 'unchanged';
            $result['message'] = 'No changes detected';
        }
        
        $websites[$index]['last_hash'] = $currentHash;
        $websites[$index]['last_checked'] = date('Y-m-d H:i:s');
    }
    
    // Save updated data
    file_put_contents(WEBSITES_FILE, json_encode($websites, JSON_PRETTY_PRINT));
    file_put_contents(HISTORY_FILE, json_encode($history, JSON_PRETTY_PRINT));
    
    return $result;
}
?>