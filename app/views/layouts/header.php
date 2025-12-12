<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/style.css">
    <?php if(defined('FONT_AWESOME_KIT') && FONT_AWESOME_KIT): ?>
    <script src="https://kit.fontawesome.com/<?php echo FONT_AWESOME_KIT; ?>.js" crossorigin="anonymous"></script>
    <?php endif; ?>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container.mt-4 {
            flex: 1;
        }
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        }
        .hero-section {
            background-size: cover !important;
            background-position: center !important;
        }
        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .btn-outline-primary {
            color: #6366f1;
            border-color: #6366f1;
        }
        .btn-outline-primary:hover {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        .text-primary {
            color: #6366f1 !important;
        }
        .bg-primary {
            background-color: #6366f1 !important;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/layouts/navbar.php'; ?>
<div class="container mt-4">
