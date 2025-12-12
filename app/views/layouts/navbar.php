<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo URLROOT; ?>">
      <i class="bi bi-fire me-2"></i><?php echo SITENAME; ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">Nosotros</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/cart">
                <i class="bi bi-cart"></i> Carrito
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></span>
                <?php endif; ?>
            </a>
        </li>
        <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i>Hola, <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario'; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/orders/history"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</a></li>
                    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin"><i class="bi bi-speedometer2 me-2"></i>Panel Admin</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/users/logout"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                </ul>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">
                    <i class="bi bi-person-plus me-1"></i>Registrarse
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
