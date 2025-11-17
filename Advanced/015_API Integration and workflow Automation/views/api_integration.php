<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4"><i class="fas fa-plug me-2"></i>API Integration</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-cloud-sun me-2"></i>Weather API Test</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?page=api&action=weather">
                    <div class="mb-3">
                        <label for="city" class="form-label">City Name</label>
                        <input type="text" class="form-control" id="city" name="city" value="London" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Get Weather</button>
                </form>
                
                <?php if(isset($weatherData)): ?>
                <div class="mt-3 p-3 bg-light rounded">
                    <h6>Weather in <?php echo $weatherData['name'] ?? 'Unknown'; ?>:</h6>
                    <?php if(isset($weatherData['main'])): ?>
                        <p>Temperature: <?php echo $weatherData['main']['temp']; ?>°C</p>
                        <p>Humidity: <?php echo $weatherData['main']['humidity']; ?>%</p>
                        <p>Conditions: <?php echo $weatherData['weather'][0]['description']; ?></p>
                    <?php else: ?>
                        <p class="text-danger">Error: <?php echo $weatherData['error'] ?? 'Unknown error'; ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-envelope me-2"></i>Email API Test</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?page=api&action=email">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Test Email</button>
                </form>
                
                <?php if(isset($emailResult)): ?>
                <div class="mt-3 alert alert-<?php echo $emailResult ? 'success' : 'danger'; ?>">
                    <?php echo $emailResult ? 'Email sent successfully!' : 'Failed to send email.'; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list-alt me-2"></i>API Call Logs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Endpoint</th>
                                <th>Status</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($apiLogs as $log): ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($log['created_at'])); ?></td>
                                <td><?php echo substr($log['endpoint'], 0, 50) . '...'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $log['status'] == 200 ? 'success' : 'danger'; ?>">
                                        <?php echo $log['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo substr($log['response_data'], 0, 100) . '...'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>