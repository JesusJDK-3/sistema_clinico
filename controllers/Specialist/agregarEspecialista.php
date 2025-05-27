
<?php
require_once __DIR__ . '/EspecialistaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombres'   => $_POST['nombres'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'dni'       => $_POST['dni'] ?? '',
        'telefono'  => $_POST['telefono'] ?? '',
        'correo'    => $_POST['correo'] ?? '',
        // Puedes agregar idarea e idsubarea si tu formulario los tiene
    ];

    $controlador = new EspecialistaController();
    $controlador->agregarEspecialista($data);

    header("Location: http://localhost/SistemaClinico/views/Clinica/Especialistas.php");
    exit;
}