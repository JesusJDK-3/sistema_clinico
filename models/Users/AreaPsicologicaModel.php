<?php
require_once __DIR__ . '/../../config/database.php';

class AreaPsicologicaModel {
    public function listarAreas() {
        $pdo = connectDatabase();
        $stmt = $pdo->query("SELECT * FROM areas");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        closeDatabase($pdo);
        return $result;
    }

    public function listarSubareas() {
        $pdo = connectDatabase();
        $stmt = $pdo->query("SELECT * FROM subareas");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        closeDatabase($pdo);
        return $result;
    }

    public function agregarArea($nombre) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("INSERT INTO areas (area) VALUES (:nombre)");
        $stmt->execute(['nombre' => $nombre]);
        closeDatabase($pdo);
    }

    public function editarArea($id, $nombre) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("UPDATE areas SET area = :nombre WHERE idarea = :id");
        $stmt->execute(['nombre' => $nombre, 'id' => $id]);
        closeDatabase($pdo);
    }

    public function deshabilitarArea($id) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("DELETE FROM areas WHERE idarea = :id");
        $stmt->execute(['id' => $id]);
        closeDatabase($pdo);
    }

    // SUBÁREAS
    public function agregarSubarea($nombre, $idarea) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("INSERT INTO subareas (subarea, idarea) VALUES (:nombre, :idarea)");
        $stmt->execute(['nombre' => $nombre, 'idarea' => $idarea]);
        closeDatabase($pdo);
    }

    public function editarSubarea($idsubarea, $nombre) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("UPDATE subareas SET subarea = :nombre WHERE idsubarea = :idsubarea");
        $stmt->execute(['nombre' => $nombre, 'idsubarea' => $idsubarea]);
        closeDatabase($pdo);
    }

    public function deshabilitarSubarea($idsubarea) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("DELETE FROM subareas WHERE idsubarea = :idsubarea");
        $stmt->execute(['idsubarea' => $idsubarea]);
        closeDatabase($pdo);
    }
}