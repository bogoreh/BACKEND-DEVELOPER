<?php
class ApiController {
    private $apiModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->apiModel = new ApiModel($this->db);
    }

    public function getWeatherData($city) {
        $url = WEATHER_API_URL . "?q=" . urlencode($city) . "&appid=" . WEATHER_API_KEY . "&units=metric";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Log the API call
        $this->apiModel->logApiCall($url, $city, $response, $httpCode);

        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        return ['error' => 'Failed to fetch weather data'];
    }

    public function sendEmail($to, $subject, $message) {
        $data = [
            'personalizations' => [
                [
                    'to' => [['email' => $to]]
                ]
            ],
            'from' => ['email' => 'noreply@yourapp.com'],
            'subject' => $subject,
            'content' => [
                ['type' => 'text/plain', 'value' => $message]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SENDGRID_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . SENDGRID_API_KEY,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->apiModel->logApiCall(SENDGRID_API_URL, json_encode($data), $response, $httpCode);

        return $httpCode === 202;
    }

    public function getApiLogs() {
        return $this->apiModel->getApiLogs();
    }
}
?>