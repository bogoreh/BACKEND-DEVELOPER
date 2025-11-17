<?php
class WorkflowController {
    private $workflowModel;
    private $apiController;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->workflowModel = new WorkflowModel($this->db);
        $this->apiController = new ApiController();
    }

    public function createWorkflow($data) {
        return $this->workflowModel->createWorkflow(
            $data['name'],
            $data['trigger'],
            $data['action'],
            $data['conditions'] ?? null
        );
    }

    public function getWorkflows() {
        return $this->workflowModel->getWorkflows();
    }

    public function toggleWorkflow($id, $status) {
        return $this->workflowModel->updateWorkflowStatus($id, $status);
    }

    public function executeWorkflow($workflowId) {
        $workflows = $this->workflowModel->getWorkflows();
        $workflow = null;
        
        foreach ($workflows as $wf) {
            if ($wf['id'] == $workflowId) {
                $workflow = $wf;
                break;
            }
        }

        if (!$workflow || !$workflow['is_active']) {
            return false;
        }

        // Execute based on workflow type
        switch ($workflow['trigger_type']) {
            case 'weather_alert':
                return $this->executeWeatherAlert($workflow);
            case 'scheduled_email':
                return $this->executeScheduledEmail($workflow);
            default:
                return false;
        }
    }

    private function executeWeatherAlert($workflow) {
        $weather = $this->apiController->getWeatherData('London');
        if (isset($weather['main']['temp'])) {
            $temp = $weather['main']['temp'];
            // Check if temperature meets conditions
            if ($temp > 25) { // Example condition
                $this->apiController->sendEmail(
                    'admin@example.com',
                    'Weather Alert',
                    "Temperature is high: {$temp}°C"
                );
                return true;
            }
        }
        return false;
    }

    private function executeScheduledEmail($workflow) {
        return $this->apiController->sendEmail(
            'user@example.com',
            'Scheduled Notification',
            'This is an automated message from your workflow.'
        );
    }
}
?>