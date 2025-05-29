<?php
require_once __DIR__ . '/EspecialistaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $controlador = new EspecialistaController();
    $horarios = $controlador->obtenerHorariosPorEspecialista($id);
    echo json_encode($horarios);
}
