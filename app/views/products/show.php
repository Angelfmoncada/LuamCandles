<?php require APPROOT . '/views/layouts/header.php'; ?>
<a href="<?php echo URLROOT; ?>/pages" class="btn btn-light mb-3"><i class="bi bi-arrow-left"></i> Volver al catálogo</a>

<div class="row">
    <div class="col-md-6">
        <img src="<?php echo URLROOT; ?>/assets/img/<?php echo $data['product']->image; ?>" class="img-fluid rounded shadow" alt="<?php echo $data['product']->name; ?>" onerror="this.src='https://via.placeholder.com/600x600/e9ecef/495057?text=<?php echo urlencode($data['product']->name); ?>'">
    </div>
    <div class="col-md-6">
        <?php flash('cart_message'); ?>
        <h2><?php echo $data['product']->name; ?></h2>
        <span class="badge bg-primary mb-3"><?php echo $data['product']->category; ?></span>
        <h3 class="text-primary fw-bold mb-3">L<?php echo number_format($data['product']->price, 2); ?></h3>
        <p class="lead"><?php echo $data['product']->description; ?></p>

        <form action="<?php echo URLROOT; ?>/cart/add/<?php echo $data['product']->id; ?>" method="POST">
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-cart-plus me-2"></i> Añadir al Carrito
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
