<?php require APPROOT . '/views/layouts/header.php'; ?>
<a href="<?php echo URLROOT; ?>/pages" class="btn btn-light mb-3"><i class="bi bi-arrow-left"></i> Volver al catálogo</a>

<div class="row">
    <div class="col-md-6">
        <img src="<?php echo URLROOT; ?>/assets/img/<?php echo $data['product']->image; ?>" class="img-fluid rounded shadow" alt="<?php echo $data['product']->name; ?>" onerror="this.src='https:
    </div>
    <div class="col-md-6">
        <?php flash('cart_message'); ?>
        <h2><?php echo $data['product']->name; ?></h2>
        <p class="lead text-muted"><?php echo $data['product']->category; ?></p>
        <h3 class="text-primary mb-3">$<?php echo $data['product']->price; ?></h3>
        <p><?php echo $data['product']->description; ?></p>

        <form action="<?php echo URLROOT; ?>/cart/add/<?php echo $data['product']->id; ?>" method="POST">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-cart-plus"></i> Agregar al Carrito
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
