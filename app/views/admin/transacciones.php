<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            <?php if(!empty($data['transacciones'])): ?>
                                <?php foreach($data['transacciones'] as $transaccion): ?>
                                    <tr>
                                        <td><?php echo $transaccion->id; ?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($transaccion->fecha_transaccion)); ?></td>
                                        <td><?php echo htmlspecialchars($transaccion->cliente_nombre, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($transaccion->cliente_email, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>$<?php echo number_format($transaccion->monto, 2); ?> USD</td>
                                        <td>
                                            <?php if($transaccion->estado == 'COMPLETED'): ?>
                                                <span class="badge bg-success">Completado</span>
                                            <?php elseif($transaccion->estado == 'PENDING'): ?>
                                                <span class="badge bg-warning">Pendiente</span>
                                            <?php elseif($transaccion->estado == 'REFUNDED'): ?>
                                                <span class="badge bg-danger">Reembolsado</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo $transaccion->estado; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><small><?php echo htmlspecialchars($transaccion->transaction_id); ?></small></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal<?php echo $transaccion->id; ?>">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal para ver detalles -->
                                    <div class="modal fade" id="modal<?php echo $transaccion->id; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detalles de Transacción #<?php echo $transaccion->id; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Información del Cliente</h6>
                                                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($transaccion->cliente_nombre, ENT_QUOTES, 'UTF-8'); ?></p>
                                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($transaccion->cliente_email, ENT_QUOTES, 'UTF-8'); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Información de la Transacción</h6>
                                                            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaccion->transaction_id); ?></p>
                                                            <p><strong>Monto:</strong> $<?php echo number_format($transaccion->monto, 2); ?> USD</p>
                                                            <p><strong>Estado:</strong> <?php echo $transaccion->estado; ?></p>
                                                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i:s', strtotime($transaccion->fecha_transaccion)); ?></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6>Datos Completos de PayPal (JSON)</h6>
                                                    <pre class="bg-light p-3" style="max-height: 300px; overflow-y: auto; font-size: 12px;"><?php echo htmlspecialchars(json_encode(json_decode($transaccion->paypal_data), JSON_PRETTY_PRINT)); ?></pre>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
