
<?php
require_once __DIR__ . '/EspecialistaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    // Aquí deberías mostrar un formulario para editar, o procesar la edición si ya enviaste los datos.
    // Ejemplo de procesamiento directo (ajusta según tu lógica):
    $data = [
        'nombres'   => $_POST['nombres'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'dni'       => $_POST['dni'] ?? '',
        'telefono'  => $_POST['telefono'] ?? '',
        'correo'    => $_POST['correo'] ?? '',
        'idarea'    => $_POST['idarea'] ?? 2,
        'idsubarea' => $_POST['idsubarea'] ?? null,
    ];

    $controlador = new EspecialistaController();
    $controlador->editarEspecialista($id, $data);

    header("Location: http://localhost/SistemaClinico/views/Clinica/principal.php");
    exit;
}
header("Location: http://localhost/SistemaClinico/views/Clinica/principal.php");
exit;