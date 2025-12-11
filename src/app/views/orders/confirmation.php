<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8 text-center">
        <div class="card shadow-lg border-0 rounded-3 p-5">
            <div class="mb-4">
                <div class="d-inline-block p-4 rounded-circle bg-success bg-opacity-10 text-success mb-3">
                    <i class="bi bi-check-lg display-1"></i>
                </div>
            </div>

            <h1 class="display-4 fw-bold text-success mb-3">¡Gracias por su compra!</h1>
            <p class="lead text-muted mb-5">Su pedido ha sido procesado exitosamente.</p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="<?php echo URLROOT; ?>" class="btn btn-primary btn-lg px-4 gap-3">Volver al Inicio</a>
                <a href="<?php echo URLROOT; ?>/orders/history" class="btn btn-outline-secondary btn-lg px-4">Ver mis Pedidos</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
