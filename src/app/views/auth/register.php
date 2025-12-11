<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-3 mt-5">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Únete a Luam Candles</h2>
                    <p class="text-muted">Crea tu cuenta para comprar más rápido</p>
                </div>

                <form action="<?php echo URLROOT; ?>/users/register" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" id="name" placeholder="Tu Nombre" value="<?php echo $data['name']; ?>">
                        <label for="name">Nombre Completo</label>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="email" placeholder="nombre@ejemplo.com" value="<?php echo $data['email']; ?>">
                        <label for="email">Correo Electrónico</label>
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" id="password" placeholder="Contraseña" value="<?php echo $data['password']; ?>">
                                <label for="password">Contraseña</label>
                                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" id="confirm_password" placeholder="Confirmar" value="<?php echo $data['confirm_password']; ?>">
                                <label for="confirm_password">Confirmar</label>
                                <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                            Registrarse <i class="bi bi-person-plus ms-2"></i>
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0 text-muted">¿Ya tienes una cuenta? <a href="<?php echo URLROOT; ?>/users/login" class="text-decoration-none fw-bold">Inicia Sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
