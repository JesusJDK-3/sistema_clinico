<?php
require_once __DIR__ . '/../../models/Specialist/EspecialistaModel.php';

class EspecialistaController {
    private $model;

    public function __construct() {
        $this->model = new EspecialistaModel();
    }

    public function listarEspecialistas() {
        return $this->model->listarEspecialistas();
    }

    public function obtenerEspecialistaPorUsuario($idusuario) {
        return $this->model->obtenerEspecialistaPorUsuario($idusuario);
    }

    // NUEVOS MÉTODOS:
    public function agregarEspecialista($data) {
        // ✅ CORRECCIÓN: Pasar true para obtener el ID
        $idespecialista = $this->model->agregarEspecialista($data, true);

        // Guardar horarios
        if (isset($data['dia_semana'])) {
            foreach ($data['dia_semana'] as $index => $dia) {
                $hora_inicio = $data['hora_inicio'][$index] ?? null;
                $hora_fin = $data['hora_fin'][$index] ?? null;
                $activo = isset($data['activo'][$index]) ? 1 : 0;

                if ($hora_inicio && $hora_fin) {
                    $this->model->agregarHorario($idespecialista, $dia, $hora_inicio, $hora_fin, $activo);
                }
            }
        }

        return $idespecialista; // Retorna el ID del especialista
    }

    public function editarEspecialista($id, $data) {
        return $this->model->editarEspecialista($id, $data);
    }

    public function deshabilitarEspecialista($id) {
        return $this->model->deshabilitarEspecialista($id);
    }

    // Agregar este método para manejar la adición de horarios
    public function agregarHorario($idespecialista, $dia, $hora_inicio, $hora_fin, $activo = 1) {
        return $this->model->agregarHorario($idespecialista, $dia, $hora_inicio, $hora_fin, $activo);
    }
    
    public function obtenerHorariosPorEspecialista($idespecialista) {
        return $this->model->obtenerHorariosPorEspecialista($idespecialista);
    }
}