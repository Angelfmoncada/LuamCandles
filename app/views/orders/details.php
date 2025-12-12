<?php require APPROOT . '/views/layouts/header.php'; ?>
<a href="<?php echo URLROOT; ?>/orders/history" class="btn btn-light mb-3"><i class="bi bi-arrow-left"></i> Volver a mis pedidos</a>
<h2>Detalles del Pedido

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach($data['details'] as $item):
                $subtotal = $item->price * $item->quantity;
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $item->product_name; ?></td>
                <td><img src="<?php echo URLROOT; ?>/assets/img/<?php echo $item->image; ?>" width="50" onerror="this.src='https:
                <td><?php echo $item->quantity; ?></td>
                <td>$<?php echo $item->price; ?></td>
                <td>$<?php echo $subtotal; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
