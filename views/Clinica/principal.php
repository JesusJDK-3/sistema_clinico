<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Clínico</title>
    <link rel="stylesheet" href="../../assets/Specialist/CssEspecialista.css">
    <link rel="stylesheet" href="../../assets/Specialist/TbEspecialista.css">
    <link rel="stylesheet" href="../../assets/Specialist/Modal.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar --><!-- container 1 -->
            <div class="sidebar">
                <div class="logo">
                    <h2>
                        <img src="../../img/icono.jpg" alt="Logo Clínica" class="logo-img">
                    </h2>
                </div>
                <div class="menu-item active">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                </div>
                <div class="menu-item">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="menu-item">
                    <i class="fas fa-cog"></i>
                </div>
            </div>

        <!-- Contenido principal -->
        <?php include 'Especialistas.php'; ?>
    </div>
</body>
</html>