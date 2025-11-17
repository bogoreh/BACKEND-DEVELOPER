<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4"><i class="fas fa-project-diagram me-2"></i>Workflows</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-plus me-2"></i>Create New Workflow</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?page=workflows&action=create">
                    <div class="mb-3">
                        <label for="name" class="form-label">Workflow Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="trigger" class="form-label">Trigger Type</label>
                        <select class="form-select" id="trigger" name="trigger" required>
                            <option value="weather_alert">Weather Alert</option>
                            <option value="scheduled_email">Scheduled Email</option>
                            <option value="api_webhook">API Webhook</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="action" class="form-label">Action Type</label>
                        <select class="form-select" id="action" name="action" required>
                            <option value="send_email">Send Email</option>
                            <option value="log_data">Log Data</option>
                            <option value="api_call">Make API Call</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="conditions" class="form-label">Conditions (JSON)</label>
                        <textarea class="form-control" id="conditions" name="conditions" rows="3" 
                                  placeholder='{"temp_above": 25, "city": "London"}'></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Workflow</button>
                </form>
                
                <?php if(isset($createResult)): ?>
                <div class="mt-3 alert alert-<?php echo $createResult ? 'success' : 'danger'; ?>">
                    <?php echo $createResult ? 'Workflow created successfully!' : 'Failed to create workflow.'; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list me-2"></i>Existing Workflows</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Trigger</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($workflows as $workflow): ?>
                            <tr>
                                <td><?php echo $workflow['name']; ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo ucfirst(str_replace('_', ' ', $workflow['trigger_type'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <?php echo ucfirst(str_replace('_', ' ', $workflow['action_type'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $workflow['is_active'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $workflow['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="index.php?page=workflows&action=toggle&id=<?php echo $workflow['id']; ?>&status=<?php echo $workflow['is_active'] ? 0 : 1; ?>" 
                                           class="btn btn-<?php echo $workflow['is_active'] ? 'warning' : 'success'; ?>">
                                            <?php echo $workflow['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                        </a>
                                        <a href="index.php?page=workflows&action=execute&id=<?php echo $workflow['id']; ?>" 
                                           class="btn btn-primary">Execute</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>