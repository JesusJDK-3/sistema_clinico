<?php
require_once __DIR__ . '/EspecialistaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $controlador = new EspecialistaController();
    $controlador->deshabilitarEspecialista($id);
}
header("Location: http://localhost/SistemaClinico/views/Clinica/Especialistas.php");
exit;