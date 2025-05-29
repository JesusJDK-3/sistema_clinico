<?php
require_once __DIR__ . '/EspecialistaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración: Muestra los datos enviados
    var_dump($_POST); // Cambia ar_dump a var_dump

    $data = [
        'nombres'   => $_POST['nombres'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'dni'       => $_POST['dni'] ?? '',
        'telefono'  => $_POST['telefono'] ?? '',
        'correo'    => $_POST['correo'] ?? '',
        'idarea'    => $_POST['idarea'] ?? 2,
        'idsubarea' => $_POST['idsubarea'] ?? null,
        'dia_semana' => $_POST['dia_semana'] ?? [], // Asegúrate de que los días se pasen
        'hora_inicio' => $_POST['hora_inicio'] ?? [], // Asegúrate de que las horas de inicio se pasen
        'hora_fin' => $_POST['hora_fin'] ?? [], // Asegúrate de que las horas de fin se pasen
        'activo' => $_POST['activo'] ?? [], // Asegúrate de que el estado activo se pase
    ];

    $controlador = new EspecialistaController();
    $idespecialista = $controlador->agregarEspecialista($data); // Cambia para que retorne el ID

    header("Location: http://localhost/SistemaClinico/views/Clinica/principal.php?pagina=especialistas");
    exit;
}
