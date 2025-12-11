<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https:
    <link rel="stylesheet" href="https:
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/style.css">
    <?php if(defined('FONT_AWESOME_KIT') && FONT_AWESOME_KIT): ?>
    <script src="https:
    <?php endif; ?>
    <style>
        body {
            background-color:
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container.mt-4 {
            flex: 1;
        }
        .card-img-top { height: 250px; object-fit: cover; }
        .hero { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https:
    </style>
</head>
<body>
<?php require APPROOT . '/views/layouts/navbar.php'; ?>
<div class="container mt-4">
