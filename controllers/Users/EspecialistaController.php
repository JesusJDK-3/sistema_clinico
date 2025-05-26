<?php
require_once __DIR__ . '/../../models/Users/EspecialistaModel.php';

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
        return $this->model->agregarEspecialista($data);
    }

    public function editarEspecialista($id, $data) {
        return $this->model->editarEspecialista($id, $data);
    }

    public function deshabilitarEspecialista($id) {
        return $this->model->deshabilitarEspecialista($id);
    }
}