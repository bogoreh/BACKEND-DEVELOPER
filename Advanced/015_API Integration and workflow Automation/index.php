<?php
// Include configuration and classes
require_once 'config/database.php';
require_once 'config/api_config.php';
require_once 'models/Database.php';
require_once 'models/ApiModel.php';
require_once 'models/WorkflowModel.php';
require_once 'controllers/ApiController.php';
require_once 'controllers/WorkflowController.php';

// Initialize controllers
$apiController = new ApiController();
$workflowController = new WorkflowController();

// Get current page
$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

// Include header
include 'views/header.php';

// Route handling
switch($page) {
    case 'dashboard':
        $apiLogs = $apiController->getApiLogs();
        $workflows = $workflowController->getWorkflows();
        $activeWorkflows = array_filter($workflows, fn($w) => $w['is_active']);
        $activeWorkflows = count($activeWorkflows);
        include 'views/dashboard.php';
        break;
        
    case 'api':
        if ($_POST) {
            if ($action === 'weather') {
                $weatherData = $apiController->getWeatherData($_POST['city']);
            } elseif ($action === 'email') {
                $emailResult = $apiController->sendEmail(
                    $_POST['email'],
                    $_POST['subject'],
                    $_POST['message']
                );
            }
        }
        $apiLogs = $apiController->getApiLogs();
        include 'views/api_integration.php';
        break;
        
    case 'workflows':
        if ($_POST && $action === 'create') {
            $createResult = $workflowController->createWorkflow($_POST);
        } elseif ($action === 'toggle') {
            $workflowController->toggleWorkflow($_GET['id'], $_GET['status']);
        } elseif ($action === 'execute') {
            $executeResult = $workflowController->executeWorkflow($_GET['id']);
        }
        $workflows = $workflowController->getWorkflows();
        include 'views/workflows.php';
        break;
        
    default:
        include 'views/dashboard.php';
        break;
}

// Include footer
include 'views/footer.php';
?>