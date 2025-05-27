<?php
require_once __DIR__ . '/../../models/Area/AreaPsicologicaModel.php';

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
    $idarea = $_POST['idarea_area'] ?? null;
    $nombre_area = $_POST['nombre_area'] ?? '';
    $subareas = $_POST['subareas'] ?? [];
    $subareasIds = $_POST['idsubareas'] ?? [];

    if ($accion === 'cargar') {
        if (!$idarea) {
            // NUEVA ÁREA
            $controller->agregarArea($nombre_area);
            $areas = $controller->listarAreas();
            $lastArea = end($areas);
            if ($lastArea && !empty($subareas)) {
                foreach ($subareas as $sub) {
                    if (trim($sub) !== '') {
                        $controller->agregarSubarea($sub, $lastArea['idarea']);
                    }
                }
            }
        } else {
            // EDITAR ÁREA Y SUBÁREAS
            $controller->editarArea($idarea, $nombre_area);

            // Obtener subáreas existentes de la BD para esta área
            $subareasExistentes = [];
            foreach ($controller->listarSubareas() as $s) {
                if ($s['idarea'] == $idarea) {
                    $subareasExistentes[$s['idsubarea']] = $s['subarea'];
                }
            }

            // 1. Eliminar subáreas que ya no están en el formulario
            foreach ($subareasExistentes as $idsubarea => $nombreSubareaExistente) {
                if (!in_array($idsubarea, $subareasIds)) {
                    $controller->deshabilitarSubarea($idsubarea);
                }
            }

            // 2. Agregar nuevas subáreas o actualizar existentes
            foreach ($subareas as $i => $nombreSubareaForm) {
                $nombreSubareaForm = trim($nombreSubareaForm);
                $idsubareaForm = $subareasIds[$i] ?? '';
                if ($nombreSubareaForm === '') continue;

                if ($idsubareaForm && isset($subareasExistentes[$idsubareaForm])) {
                    // Si el nombre cambió, actualiza
                    if ($subareasExistentes[$idsubareaForm] !== $nombreSubareaForm) {
                        $controller->editarSubarea($idsubareaForm, $nombreSubareaForm);
                    }
                } else {
                    // Es nueva, agregar
                    $controller->agregarSubarea($nombreSubareaForm, $idarea);
                }
            }
        }
    } elseif ($accion === 'deshabilitar' && $idarea) {
        $controller->deshabilitarArea($idarea);
    }
    header("Location: http://localhost/SistemaClinico/views/Clinica/Especialistas.php");
    exit;
}