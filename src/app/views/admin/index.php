<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="d-flex">
    
    <?php require APPROOT . '/views/layouts/sidebar.php'; ?>

    
    <div class="flex-grow-1 p-4">
        <?php flash('admin_message'); ?>
        <h1 class="mb-4">Historial de Transacciones</h1>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fa-solid fa-list-ul me-2"></i>Todas las Transacciones</h5>
                    <div class="btn-group">
                        <a href="?sort=date_desc" class="btn btn-outline-secondary btn-sm <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'date_desc') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-arrow-down-9-1"></i> Más recientes
                        </a>
                        <a href="?sort=date_asc" class="btn btn-outline-secondary btn-sm <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_asc') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-arrow-up-1-9"></i> Más antiguos
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID Pedido</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Método</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Ref. Transacción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['orders'] as $order): ?>
                            <tr>
                                <td class="ps-4 fw-bold">
                                <td>
                                    <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                    <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold"><?php echo $order->user_name; ?></span>
                                        <small class="text-muted"><?php echo $order->user_email; ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo $order->payment_method; ?>
                                    </span>
                                </td>
                                <td class="fw-bold text-success">$<?php echo number_format($order->total_amount, 2); ?></td>
                                <td>
                                    <?php
                                        $badgeClass = 'bg-warning text-dark';
                                        if($order->status == 'completed') $badgeClass = 'bg-success';
                                        if($order->status == 'cancelled') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge rounded-pill <?php echo $badgeClass; ?>">
                                        <?php echo ucfirst($order->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted font-monospace">
                                        <?php echo $order->transaction_id ? $order->transaction_id : '-'; ?>
                                    </small>
                                </td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/admin/update_status/<?php echo $order->id; ?>" method="POST" class="d-inline-flex align-items-center">
                                        <select name="status" class="form-select form-select-sm me-2" style="width: 110px;" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $order->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="completed" <?php echo $order->status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo $order->status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </form>
                                    <a href="<?php echo URLROOT; ?>/admin/details/<?php echo $order->id; ?>" class="btn btn-outline-info btn-sm" title="Ver Detalles">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
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

<style>

    body > nav.navbar { display: none; }
    body > .container { max-width: 100%; padding: 0; margin: 0; }

    footer { margin-top: 0 !important; z-index: 10; position: relative; }
</style>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
