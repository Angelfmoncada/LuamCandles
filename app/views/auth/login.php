<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-3 mt-5">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">¡Bienvenido de nuevo!</h2>
                    <p class="text-muted">Ingresa tus credenciales para continuar</p>
                </div>

                <?php flash('register_success'); ?>

                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="email" placeholder="nombre@ejemplo.com" value="<?php echo $data['email']; ?>">
                        <label for="email">Correo Electrónico</label>
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" id="password" placeholder="Contraseña" value="<?php echo $data['password']; ?>" style="padding-right: 40px;">
                        <label for="password">Contraseña</label>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePasswordVisibility()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>

                    <script>
                        function togglePasswordVisibility() {
                            const passwordInput = document.getElementById('password');
                            const toggleIcon = document.getElementById('toggleIcon');

                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.classList.remove('bi-eye');
                                toggleIcon.classList.add('bi-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.classList.remove('bi-eye-slash');
                                toggleIcon.classList.add('bi-eye');
                            }
                        }
                    </script>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                            Iniciar Sesión <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0 text-muted">¿No tienes una cuenta? <a href="<?php echo URLROOT; ?>/users/register" class="text-decoration-none fw-bold">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
