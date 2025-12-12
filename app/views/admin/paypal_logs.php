<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="d-flex">
    
    <?php require APPROOT . '/views/layouts/sidebar.php'; ?>

    
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fa-brands fa-paypal me-2 text-primary"></i>Historial de Transacciones</h1>
        </div>

        <?php if(empty($data['logs'])): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No hay logs de PayPal registrados aún.
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Fecha/Hora</th>
                                    <th>Nombre Cliente</th>
                                    <th>Email Cliente</th>
                                    <th>Monto</th>
                                    <th>Transaction ID</th>
                                    <th>Tipo de Evento</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['logs'] as $log):

                                    $payerInfo = json_decode($log->response_json, true);
                                    $payerName = '-';
                                    $payerEmail = '-';
                                    $amount = '-';

                                    if($payerInfo) {

                                        if(isset($payerInfo['payer']['name']['given_name']) && isset($payerInfo['payer']['name']['surname'])) {
                                            $payerName = $payerInfo['payer']['name']['given_name'] . ' ' . $payerInfo['payer']['name']['surname'];
                                        } elseif(isset($payerInfo['payer']['name'])) {
                                            $payerName = $payerInfo['payer']['name'];
                                        } elseif(isset($payerInfo['details']['payer']['name']['given_name'])) {
                                            $payerName = $payerInfo['details']['payer']['name']['given_name'] . ' ' . $payerInfo['details']['payer']['name']['surname'];
                                        }

                                        if(isset($payerInfo['payer']['email_address'])) {
                                            $payerEmail = $payerInfo['payer']['email_address'];
                                        } elseif(isset($payerInfo['details']['payer']['email_address'])) {
                                            $payerEmail = $payerInfo['details']['payer']['email_address'];
                                        }

                                        if(isset($payerInfo['purchase_units'][0]['amount']['value'])) {
                                            $amount = '$' . number_format($payerInfo['purchase_units'][0]['amount']['value'], 2);
                                        } elseif(isset($payerInfo['details']['purchase_units'][0]['amount']['value'])) {
                                            $amount = '$' . number_format($payerInfo['details']['purchase_units'][0]['amount']['value'], 2);
                                        } elseif(isset($payerInfo['amount']['total'])) {
                                            $amount = '$' . number_format($payerInfo['amount']['total'], 2);
                                        }
                                    }
                                ?>
                                <tr>
                                    <td class="ps-4"><?php echo $log->id; ?></td>
                                    <td>
                                        <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                        <?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-user me-1 text-muted"></i>
                                        <?php echo $payerName; ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-envelope me-1 text-muted"></i>
                                        <small><?php echo $payerEmail; ?></small>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?php echo $amount; ?></strong>
                                    </td>
                                    <td>
                                        <small class="font-monospace text-primary">
                                            <?php echo $log->transaction_id ? $log->transaction_id : '-'; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php
                                            $badgeClass = 'bg-secondary';
                                            if($log->event_type == 'payment_capture') $badgeClass = 'bg-success';
                                            if($log->event_type == 'order_created') $badgeClass = 'bg-info';
                                            if($log->event_type == 'payment_refund') $badgeClass = 'bg-warning text-dark';
                                            if($log->event_type == 'error') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge rounded-pill <?php echo $badgeClass; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $log->event_type)); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="
                                            <i class="fa-solid fa-eye"></i> Ver Detalles
                                        </button>

                                        
                                        <div class="modal fade" id="logModal<?php echo $log->id; ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fa-solid fa-receipt me-2"></i>
                                                            Detalles de Transacción
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div class="card mb-3">
                                                            <div class="card-header bg-light">
                                                                <strong><i class="fa-solid fa-user me-2"></i>Información del Cliente</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-2">
                                                                        <small class="text-muted">Nombre:</small><br>
                                                                        <strong><?php echo $payerName; ?></strong>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <small class="text-muted">Email:</small><br>
                                                                        <strong><?php echo $payerEmail; ?></strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="card mb-3">
                                                            <div class="card-header bg-light">
                                                                <strong><i class="fa-solid fa-credit-card me-2"></i>Información de la Transacción</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4 mb-2">
                                                                        <small class="text-muted">Transaction ID:</small><br>
                                                                        <code><?php echo $log->transaction_id ?: 'N/A'; ?></code>
                                                                    </div>
                                                                    <div class="col-md-4 mb-2">
                                                                        <small class="text-muted">Monto:</small><br>
                                                                        <strong class="text-success fs-5"><?php echo $amount; ?></strong>
                                                                    </div>
                                                                    <div class="col-md-4 mb-2">
                                                                        <small class="text-muted">Tipo de Evento:</small><br>
                                                                        <span class="badge <?php echo $badgeClass; ?>">
                                                                            <?php echo ucfirst(str_replace('_', ' ', $log->event_type)); ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 mb-2">
                                                                        <small class="text-muted">Fecha:</small><br>
                                                                        <strong><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></strong>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2">
                                                                        <small class="text-muted">Pedido
                                                                        <strong>
                                                                            <?php if($log->order_id): ?>
                                                                                <a href="<?php echo URLROOT; ?>/admin/details/<?php echo $log->order_id; ?>">

                                                                                </a>
                                                                            <?php else: ?>
                                                                                N/A
                                                                            <?php endif; ?>
                                                                        </strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="accordion" id="jsonAccordion<?php echo $log->id; ?>">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="heading<?php echo $log->id; ?>">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="
                                                                        <i class="fa-solid fa-code me-2"></i> Ver Respuesta JSON Completa
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse<?php echo $log->id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $log->id; ?>">
                                                                    <div class="accordion-body">
                                                                        <pre class="bg-light p-3 rounded border" style="max-height: 400px; overflow-y: auto;"><code><?php
                                                                            if($log->response_json) {
                                                                                $json = json_decode($log->response_json);
                                                                                echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                                                            } else {
                                                                                echo 'No data';
                                                                            }
                                                                        ?></code></pre>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-times me-2"></i>Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    Total de registros: <?php echo count($data['logs']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>

    body > nav.navbar { display: none; }
    body > .container { max-width: 100%; padding: 0; margin: 0; }

    footer { margin-top: 0 !important; z-index: 10; position: relative; }
</style>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
