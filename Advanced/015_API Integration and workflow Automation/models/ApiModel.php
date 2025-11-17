<?php
class ApiModel {
    private $conn;
    private $table_name = "api_logs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function logApiCall($endpoint, $request, $response, $status) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET endpoint=:endpoint, request_data=:request, 
                  response_data=:response, status=:status, created_at=NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":endpoint", $endpoint);
        $stmt->bindParam(":request", $request);
        $stmt->bindParam(":response", $response);
        $stmt->bindParam(":status", $status);

        return $stmt->execute();
    }

    public function getApiLogs() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC LIMIT 50";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>