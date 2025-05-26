<?php
require_once __DIR__ . '/../../config/database.php';

class EspecialistaModel {
    public function listarEspecialistas() {
        $pdo = connectDatabase();
        $stmt = $pdo->query("SELECT e.*, u.nombres, u.apellidos, u.dni, u.telefono, u.correo, a.area, s.subarea
            FROM especialistas e
            INNER JOIN usuarios u ON e.idusuario = u.idusuario
            INNER JOIN areas a ON e.idarea = a.idarea
            LEFT JOIN subareas s ON e.idsubarea = s.idsubarea");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        closeDatabase($pdo);
        return $result;
    }

    public function obtenerEspecialistaPorUsuario($idusuario) {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("SELECT e.*, u.nombres, u.apellidos, u.dni, u.telefono, u.correo, a.area, s.subarea
            FROM especialistas e
            INNER JOIN usuarios u ON e.idusuario = u.idusuario
            INNER JOIN areas a ON e.idarea = a.idarea
            LEFT JOIN subareas s ON e.idsubarea = s.idsubarea
            WHERE e.idusuario = :idusuario");
        $stmt->execute(['idusuario' => $idusuario]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        closeDatabase($pdo);
        return $result;
    }

    public function agregarEspecialista($data) {
        $pdo = connectDatabase();

        // Insertar en usuarios
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombres, apellidos, dni, telefono, correo, idestado, idrol, usuario, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $usuario = strtolower(explode(' ', $data['nombres'])[0]) . rand(100,999);
        $password = password_hash($data['dni'], PASSWORD_DEFAULT); // Contraseña igual que el DNI
        $idrol = 3; // Rol especialista
        $idestado = 1; // Activo

        $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['dni'],
            $data['telefono'],
            $data['correo'],
            $idestado,
            $idrol,
            $usuario,
            $password
        ]);
        $idusuario = $pdo->lastInsertId();

        // Insertar en especialistas
        $idarea = $data['idarea'] ?? 2;
        $idsubarea = $data['idsubarea'] ?? null;
        $stmt2 = $pdo->prepare("INSERT INTO especialistas (idusuario, idarea, idsubarea) VALUES (?, ?, ?)");
        $stmt2->execute([$idusuario, $idarea, $idsubarea]);

        closeDatabase($pdo);
        return true;
    }

    public function editarEspecialista($id, $data) {
        $pdo = connectDatabase();

        // Actualizar datos en usuarios
        $stmt = $pdo->prepare("UPDATE usuarios SET nombres=?, apellidos=?, dni=?, telefono=?, correo=? WHERE idusuario=(SELECT idusuario FROM especialistas WHERE idespecialista=?)");
        $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['dni'],
            $data['telefono'],
            $data['correo'],
            $id
        ]);

        // Actualizar datos en especialistas
        $stmt2 = $pdo->prepare("UPDATE especialistas SET idarea=?, idsubarea=? WHERE idespecialista=?");
        $stmt2->execute([
            $data['idarea'],
            $data['idsubarea'],
            $id
        ]);

        closeDatabase($pdo);
        return true;
    }

    public function deshabilitarEspecialista($id) {
        $pdo = connectDatabase();
        // Cambia el estado del usuario a inactivo (0)
        $stmt = $pdo->prepare("UPDATE usuarios SET idestado=0 WHERE idusuario=(SELECT idusuario FROM especialistas WHERE idespecialista=?)");
        $stmt->execute([$id]);
        closeDatabase($pdo);
        return true;
    }
}