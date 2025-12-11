<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">Nosotros</a>
        </li>
      </ul>

      <form class="d-flex me-3" action="<?php echo URLROOT; ?>/pages/search" method="POST">
        <input class="form-control me-2" type="search" name="search" placeholder="Buscar velas..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/cart">
                <i class="bi bi-cart"></i> Carrito
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="badge bg-danger"><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></span>
                <?php endif; ?>
            </a>
        </li>
        <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Hola, <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario'; ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/orders/history">Mis Pedidos</a></li>
                    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin">Panel Admin</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout">Cerrar Sesión</a></li>
                </ul>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Registrarse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Iniciar Sesión</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
