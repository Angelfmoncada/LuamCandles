<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="p-5 mb-5 bg-light rounded-3 hero-section position-relative" style="background: url('<?php echo URLROOT; ?>/assets/img/Screenshot 2025-07-26 042148.png') no-repeat center center; background-size: cover; height: 500px;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded-3"></div>
    <div class="container-fluid py-5 position-relative text-white h-100 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-3 fw-bold">Ilumina Tus Momentos</h1>
        <p class="fs-4 mb-4">Velas artesanales de soja, creadas con pasión y aromas naturales.</p>
        <a href="#catalogo" class="btn btn-primary btn-lg">Ver Colección</a>
    </div>
</div>

<div class="container px-4 py-5" id="features">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 text-center">
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-flower1"></i>
            </div>
            <h2>100% Natural</h2>
            <p>Utilizamos cera de soja biodegradable y aceites esenciales puros, libres de ftalatos y parabenos para un hogar más saludable.</p>
        </div>
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-heart-fill"></i>
            </div>
            <h2>Hecho a Mano</h2>
            <p>Cada vela es vertida a mano en pequeños lotes para asegurar la máxima calidad y atención al detalle en cada producto.</p>
        </div>
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-recycle"></i>
            </div>
            <h2>Sostenible</h2>
            <p>Nuestros envases son reutilizables y reciclables. Nos comprometemos a reducir nuestro impacto ambiental en cada paso.</p>
        </div>
    </div>
</div>

<div class="container" id="catalogo">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="display-5 fw-bold text-dark">Nuestra Colección</h2>
            <p class="text-muted">Descubre aromas que cuentan historias</p>
            <hr class="w-25 mx-auto text-primary opacity-100">
        </div>
    </div>

    <?php flash('cart_message'); ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach($data['products'] as $product) : ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 product-card" style="transition: transform 0.3s;">
                    <img src="<?php echo URLROOT; ?>/assets/img/<?php echo $product->image; ?>"
                         class="card-img-top"
                         alt="<?php echo $product->name; ?>"
                         style="height: 300px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/400x300/e9ecef/495057?text=<?php echo urlencode($product->name); ?>'">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0"><?php echo $product->name; ?></h5>
                            <span class="badge bg-primary"><?php echo $product->category; ?></span>
                        </div>
                        <p class="card-text text-muted flex-grow-1"><?php echo substr($product->description, 0, 100); ?>...</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-primary fw-bold mb-0">L<?php echo number_format($product->price, 2); ?></h4>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?php echo URLROOT; ?>/pages/product/<?php echo $product->id; ?>" class="btn btn-outline-primary">
                                    Ver Detalles
                                </a>
                                <form action="<?php echo URLROOT; ?>/cart/add/<?php echo $product->id; ?>" method="POST">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-cart-plus me-1"></i> Añadir al Carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="bg-light mt-5 py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Sobre Luam Candles</h2>
                <p class="lead text-muted">Más que una vela, una experiencia.</p>
                <p>En Luam Candles, creemos que el aroma tiene el poder de transformar espacios y estados de ánimo. Nacimos con la misión de crear luz y calidez en los hogares de manera consciente y sostenible.</p>
                <p>Nuestra inspiración viene de la naturaleza y los momentos simples de la vida. Desde el diseño minimalista de nuestros envases hasta la selección cuidadosa de fragancias, todo está pensado para brindarte un momento de paz en tu día a día.</p>
                <a href="#" class="btn btn-outline-dark mt-3">Conoce nuestra historia</a>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <img src="<?php echo URLROOT; ?>/assets/img/Screenshot 2025-07-26 042344.png" class="img-fluid rounded shadow-lg" alt="About Us" onerror="this.src='https://via.placeholder.com/600x400/e9ecef/495057?text=Luam+Candles'">
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h3>Únete a nuestra comunidad</h3>
            <p class="text-muted">Suscríbete para recibir ofertas exclusivas, consejos de aromaterapia y novedades.</p>
            <form class="row g-2 justify-content-center mt-3">
                <div class="col-auto">
                    <label for="email" class="visually-hidden">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="tu@email.com">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Suscribirse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
