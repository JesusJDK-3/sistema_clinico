<?php
require_once __DIR__ . '/../../models/Users/AreaPsicologicaModel.php';

class AreaPsicologicaController {
    private $model;

    public function __construct() {
        $this->model = new AreaPsicologicaModel();
    }

    public function listarAreas() {
        return $this->model->listarAreas();
    }

    public function listarSubareas() {
        return $this->model->listarSubareas();
    }

    public function agregarArea($nombre) {
        return $this->model->agregarArea($nombre);
    }

    public function editarArea($id, $nombre) {
        return $this->model->editarArea($id, $nombre);
    }

    public function deshabilitarArea($id) {
        return $this->model->deshabilitarArea($id);
    }

    // SUBÁREAS
    public function agregarSubarea($nombre, $idarea) {
        return $this->model->agregarSubarea($nombre, $idarea);
    }

    public function editarSubarea($idsubarea, $nombre) {
        return $this->model->editarSubarea($idsubarea, $nombre);
    }

    public function deshabilitarSubarea($idsubarea) {
        return $this->model->deshabilitarSubarea($idsubarea);
    }
}

// Procesamiento del formulario de áreas y subáreas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AreaPsicologicaController();
    $accion = $_POST['accion'] ?? '';
    $idarea = $_POST['idarea'] ?? null;
    $nombre_area = $_POST['nombre_area'] ?? '';
    $nombre_subarea = $_POST['nombre_subarea'] ?? '';

    if ($accion === 'guardar') {
        if ($idarea) {
            // Editar área
            $controller->editarArea($idarea, $nombre_area);
            // Si hay subárea, editar o agregar
            $subareas = $controller->listarSubareas();
            $subareaExistente = null;
            foreach ($subareas as $s) {
                if ($s['idarea'] == $idarea) {
                    $subareaExistente = $s;
                    break;
                }
            }
            if ($nombre_subarea) {
                if ($subareaExistente) {
                    $controller->editarSubarea($subareaExistente['idsubarea'], $nombre_subarea);
                } else {
                    $controller->agregarSubarea($nombre_subarea, $idarea);
                }
            }
        } else {
            // Nueva área
            $controller->agregarArea($nombre_area);
            // Obtener el idarea recién insertado
            $areas = $controller->listarAreas();
            $lastArea = end($areas);
            if ($nombre_subarea && $lastArea) {
                $controller->agregarSubarea($nombre_subarea, $lastArea['idarea']);
            }
        }
    } elseif ($accion === 'deshabilitar' && $idarea) {
        $controller->deshabilitarArea($idarea);
    }
    header("Location: http://localhost/SistemaClinico/views/Clinica/Especialistas.php");
    exit;
}