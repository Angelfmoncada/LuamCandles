<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="d-flex">
    
    <?php require APPROOT . '/views/layouts/sidebar.php'; ?>

    
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fa-solid fa-file-invoice me-2 text-primary"></i>Detalles del Pedido
            <a href="<?php echo URLROOT; ?>/admin" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Volver al Panel
            </a>
        </div>

        <div class="row">
            
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Información del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Nombre:</strong>
                            <p class="text-muted mb-0"><?php echo $data['order']->user_name; ?></p>
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong>
                            <p class="text-muted mb-0">
                                <a href="mailto:<?php echo $data['order']->user_email; ?>" class="text-decoration-none">
                                    <?php echo $data['order']->user_email; ?>
                                </a>
                            </p>
                        </div>
                        <hr>
                        <h5 class="mb-3"><i class="fa-solid fa-truck me-2"></i>Datos de Envío</h5>
                        <div class="mb-3">
                            <strong>Dirección:</strong>
                            <div class="p-3 bg-light rounded mt-1 border">
                                <?php echo nl2br($data['order']->shipping_address); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Método de Pago:</strong>
                            <span class="badge bg-primary"><?php echo $data['order']->payment_method; ?></span>
                        </div>
                        <div class="mb-3">
                            <strong>Transaction ID (App):</strong>
                            <code class="text-dark bg-light px-2 py-1 rounded border ms-2">
                                <?php echo $data['order']->transaction_id ?: 'N/A'; ?>
                            </code>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa-solid fa-box-open me-2"></i>Productos</h5>

                        
                        <?php
                            $badgeClass = 'bg-secondary';
                            if($data['order']->status == 'completed') $badgeClass = 'bg-success';
                            if($data['order']->status == 'cancelled') $badgeClass = 'bg-danger';
                            if($data['order']->status == 'pending') $badgeClass = 'bg-warning text-dark';
                        ?>
                        <span class="badge <?php echo $badgeClass; ?> fs-6">
                            <?php echo ucfirst($data['order']->status); ?>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Producto</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['details'] as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo URLROOT; ?>/assets/img/<?php echo $item->image; ?>"
                                                     alt="<?php echo $item->product_name; ?>"
                                                     class="rounded me-3"
                                                     width="40" height="40"
                                                     style="object-fit: cover;"
                                                     onerror="this.src='https:
                                                <div>
                                                    <div class="fw-bold"><?php echo $item->product_name; ?></div>
                                                    <small class="text-muted">$<?php echo number_format($item->price, 2); ?> x <?php echo $item->quantity; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo $item->quantity; ?></td>
                                        <td class="text-end pe-4 fw-bold">$<?php echo number_format($item->price * $item->quantity, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold pt-3">Total del Pedido:</td>
                                        <td class="text-end pe-4 fw-bold text-success fs-5 pt-3">
                                            $<?php echo number_format($data['order']->total_amount, 2); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-3 pb-4 text-center">
                        <form action="<?php echo URLROOT; ?>/admin/update_status/<?php echo $data['order']->id; ?>" method="POST" class="d-inline-block">
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold">Cambiar Estado:</span>
                                <select name="status" class="form-select">
                                    <option value="pending" <?php echo $data['order']->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo $data['order']->status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo $data['order']->status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if(!empty($data['paypal_logs'])): ?>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa-brands fa-paypal me-2"></i>Historial de Transacciones PayPal (Raw Data)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="accordionPayPal">
                            <?php foreach($data['paypal_logs'] as $index => $log): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                                        <button class="accordion-button <?php echo $index !== 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="
                                            <div class="d-flex w-100 justify-content-between align-items-center me-3">
                                                <span>
                                                    <span class="badge bg-light text-dark border me-2"><?php echo $log->event_type; ?></span>
                                                    <small class="font-monospace"><?php echo $log->transaction_id; ?></small>
                                                </span>
                                                <small class="text-muted"><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></small>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-bs-parent="
                                        <div class="accordion-body bg-light">
                                            <h6>Respuesta JSON Completa:</h6>
                                            <pre class="bg-dark text-success p-3 rounded" style="max-height: 300px; overflow-y: auto;"><code><?php
                                                $json = json_decode($log->response_json);
                                                echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                            ?></code></pre>

                                            <?php if($json && isset($json->payer)): ?>
                                                <div class="alert alert-info mt-3 mb-0">
                                                    <strong><i class="fa-solid fa-id-card me-2"></i>Datos del Pagador (PayPal):</strong><br>
                                                    Nombre: <?php echo isset($json->payer->name->given_name) ? $json->payer->name->given_name . ' ' . $json->payer->name->surname : 'N/A'; ?><br>
                                                    Email: <?php echo isset($json->payer->email_address) ? $json->payer->email_address : 'N/A'; ?><br>
                                                    ID Payer: <?php echo isset($json->payer->payer_id) ? $json->payer->payer_id : 'N/A'; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
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
