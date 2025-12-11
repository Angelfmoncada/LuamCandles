<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> - Admin Panel</title>
    <link href="https:
    <?php if(defined('FONT_AWESOME_KIT') && FONT_AWESOME_KIT): ?>
    <script src="https:
    <?php endif; ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 2rem;
            background-color:
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php require APPROOT . '/views/layouts/sidebar.php'; ?>

        <div class="main-content">
            <div class="container-fluid">
        <h1 class="mb-4"><i class="fa-brands fa-paypal me-2"></i>Historial de Transacciones</h1>

        <?php flash('admin_message'); ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha/Hora</th>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Transaction ID</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data['logs'])): ?>
                                <?php foreach($data['logs'] as $log): ?>
                                    <?php

                                    $payerInfo = json_decode($log->response_json, true);
                                    $payerName = '-';
                                    $payerEmail = '-';
                                    $amount = '-';
                                    $estado = 'COMPLETED';

                                    if($payerInfo) {

                                        if(isset($payerInfo['details']['status'])) {
                                            $estado = $payerInfo['details']['status'];
                                        } elseif(isset($payerInfo['status'])) {
                                            $estado = $payerInfo['status'];
                                        }
                                    }

                                    if($estado == 'REFUNDED') {
                                        continue;
                                    }

                                    if($payerInfo) {

                                        if(isset($payerInfo['details']['payer']['name']['given_name']) && isset($payerInfo['details']['payer']['name']['surname'])) {
                                            $payerName = $payerInfo['details']['payer']['name']['given_name'] . ' ' . $payerInfo['details']['payer']['name']['surname'];
                                        } elseif(isset($payerInfo['payer']['name']['given_name']) && isset($payerInfo['payer']['name']['surname'])) {
                                            $payerName = $payerInfo['payer']['name']['given_name'] . ' ' . $payerInfo['payer']['name']['surname'];
                                        }

                                        if(isset($payerInfo['details']['payer']['email_address'])) {
                                            $payerEmail = $payerInfo['details']['payer']['email_address'];
                                        } elseif(isset($payerInfo['payer']['email_address'])) {
                                            $payerEmail = $payerInfo['payer']['email_address'];
                                        }

                                        if(isset($payerInfo['details']['purchase_units'][0]['amount']['value'])) {
                                            $amount = 'L' . number_format($payerInfo['details']['purchase_units'][0]['amount']['value'], 2);
                                        } elseif(isset($payerInfo['purchase_units'][0]['amount']['value'])) {
                                            $amount = 'L' . number_format($payerInfo['purchase_units'][0]['amount']['value'], 2);
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $log->id; ?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                        <td><?php echo htmlspecialchars($payerName); ?></td>
                                        <td><?php echo htmlspecialchars($payerEmail); ?></td>
                                        <td><?php echo $amount; ?> HNL</td>
                                        <td>
                                            <?php if($estado == 'COMPLETED'): ?>
                                                <span class="badge bg-success">Completado</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning"><?php echo $estado; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><small><?php echo htmlspecialchars($log->transaction_id); ?></small></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        </td>
                                    </tr>

                                    
                                    <div class="modal fade" id="modal<?php echo $log->id; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detalles de Transacción
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Información del Cliente</h6>
                                                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($payerName); ?></p>
                                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($payerEmail); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Información de la Transacción</h6>
                                                            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($log->transaction_id); ?></p>
                                                            <p><strong>Monto:</strong> <?php echo $amount; ?> HNL</p>
                                                            <p><strong>Estado:</strong> <?php echo $estado; ?></p>
                                                            <p><strong>Tipo:</strong> <?php echo $log->event_type; ?></p>
                                                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6>Datos Completos de PayPal (JSON)</h6>
                                                    <pre class="bg-light p-3" style="max-height: 300px; overflow-y: auto; font-size: 12px;"><?php echo htmlspecialchars(json_encode(json_decode($log->response_json), JSON_PRETTY_PRINT)); ?></pre>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay transacciones registradas</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    <script src="https:
</body>
</html>
