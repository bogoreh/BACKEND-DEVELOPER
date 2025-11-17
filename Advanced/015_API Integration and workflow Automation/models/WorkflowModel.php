<?php
class WorkflowModel {
    private $conn;
    private $table_name = "workflows";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createWorkflow($name, $trigger, $action, $conditions = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name, trigger_type=:trigger, action_type=:action, 
                  conditions=:conditions, is_active=1, created_at=NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":trigger", $trigger);
        $stmt->bindParam(":action", $action);
        $stmt->bindParam(":conditions", $conditions);

        return $stmt->execute();
    }

    public function getWorkflows() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateWorkflowStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET is_active=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>