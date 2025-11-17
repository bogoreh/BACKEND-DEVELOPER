<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">API Calls</h4>
                        <h2><?php echo count($apiLogs); ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exchange-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Active Workflows</h4>
                        <h2><?php echo $activeWorkflows; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-play-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Total Workflows</h4>
                        <h2><?php echo count($workflows); ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-project-diagram fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history me-2"></i>Recent API Calls</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(array_slice($apiLogs, 0, 5) as $log): ?>
                            <tr>
                                <td><?php echo substr($log['endpoint'], 0, 30) . '...'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $log['status'] == 200 ? 'success' : 'danger'; ?>">
                                        <?php echo $log['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('H:i', strtotime($log['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list me-2"></i>Recent Workflows</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Trigger</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(array_slice($workflows, 0, 5) as $workflow): ?>
                            <tr>
                                <td><?php echo $workflow['name']; ?></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $workflow['trigger_type'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $workflow['is_active'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $workflow['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
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