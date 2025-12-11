<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <?php flash('order_success'); ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Mis Pedidos</h2>
            <?php if(!empty($data['orders'])): ?>
            <div class="btn-group">
                <a href="<?php echo URLROOT; ?>/orders/history?sort=date_desc" class="btn btn-outline-secondary btn-sm <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'date_desc') ? 'active' : ''; ?>">
                    <i class="bi bi-sort-down"></i> Más recientes
                </a>
                <a href="<?php echo URLROOT; ?>/orders/history?sort=date_asc" class="btn btn-outline-secondary btn-sm <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_asc') ? 'active' : ''; ?>">
                    <i class="bi bi-sort-up"></i> Más antiguos
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php if(empty($data['orders'])): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No has realizado pedidos aún.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Método de Pago</th>
                            <th>Ref. Transacción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['orders'] as $order): ?>
                        <tr>
                            <td>
                            <td>
                                <i class="bi bi-calendar-event me-1"></i>
                                <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?>
                            </td>
                            <td>$<?php echo number_format($order->total_amount, 2); ?></td>
                            <td>
                                <span class="badge <?php
                                    echo $order->status == 'completed' ? 'bg-success' :
                                        ($order->status == 'cancelled' ? 'bg-danger' : 'bg-warning');
                                ?>">
                                    <?php echo ucfirst($order->status); ?>
                                </span>
                            </td>
                            <td><?php echo $order->payment_method; ?></td>
                            <td><small class="text-muted"><?php echo isset($order->transaction_id) ? $order->transaction_id : '-'; ?></small></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/orders/details/<?php echo $order->id; ?>" class="btn btn-info btn-sm text-white">Ver Detalles</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
