<?php require APPROOT . '/views/layouts/header.php'; ?>
<h1>Carrito de Compras</h1>
<?php if(empty($data['cart'])): ?>
    <div class="alert alert-info">Tu carrito está vacío. <a href="<?php echo URLROOT; ?>/pages">Ir a comprar</a></div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['cart'] as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>L<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form action="<?php echo URLROOT; ?>/cart/update/<?php echo $item['id']; ?>" method="GET" class="d-flex">
                            
                             <input type="number" min="1" value="<?php echo $item['quantity']; ?>" class="form-control me-2" style="width: 80px;" onchange="window.location.href='<?php echo URLROOT; ?>/cart/update/<?php echo $item['id']; ?>/' + this.value">
                        </form>
                    </td>
                    <td>L<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/cart/remove/<?php echo $item['id']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-6 text-end">
            <h3>Total: L<?php echo number_format($data['total'], 2); ?> HNL</h3>
            <a href="<?php echo URLROOT; ?>/cart/clear" class="btn btn-warning me-2">Vaciar Carrito</a>
            <a href="<?php echo URLROOT; ?>/orders/checkout" class="btn btn-success">Proceder al Pago</a>
        </div>
    </div>
<?php endif; ?>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
