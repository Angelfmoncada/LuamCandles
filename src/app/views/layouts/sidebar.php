<nav class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100" style="width: 280px; min-height: 100vh;" aria-label="Panel de administración">
    <a href="<?php echo URLROOT; ?>/admin" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" aria-label="Inicio del panel de administración">
        <i class="fa-solid fa-fire-flame-curved fa-2x me-2" aria-hidden="true"></i>
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" role="navigation">
        <li class="nav-item">
            <a href="<?php echo URLROOT; ?>/admin"
               class="nav-link text-white <?php echo (!isset($_GET['url']) || $_GET['url'] == 'admin') ? 'active' : ''; ?>"
               aria-label="Historial de Transacciones"
               aria-current="<?php echo (!isset($_GET['url']) || $_GET['url'] == 'admin') ? 'page' : 'false'; ?>">
                <i class="fa-brands fa-paypal me-2" aria-hidden="true"></i>
                Historial de Transacciones
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#"
           class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
           id="dropdownUser1"
           data-bs-toggle="dropdown"
           aria-expanded="false"
           aria-haspopup="true"
           role="button">
            <img src="https:
                 alt="Avatar de <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'; ?>"
                 width="32"
                 height="32"
                 class="rounded-circle me-2">
            <strong><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>" tabindex="0"><i class="fa-solid fa-store me-2"></i>Ver Tienda</a></li>
            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/orders/history" tabindex="0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Mis Pedidos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout" tabindex="0"><i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>

<style>
    .nav-link {
        transition: all 0.3s ease;
        border-radius: 0.375rem;
        margin-bottom: 0.25rem;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .nav-link.active {
        background-color:
        font-weight: 600;
    }

    .nav-link:focus {
        outline: 2px solid
        outline-offset: 2px;
    }

    .dropdown-item {
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(3px);
    }

    .dropdown-item:focus {
        outline: 2px solid
        outline-offset: -2px;
    }
</style>
