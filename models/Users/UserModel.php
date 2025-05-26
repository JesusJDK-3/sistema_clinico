<?php
// Importa la clase PDO
require_once __DIR__ . '/../../config/database.php'; 
class UsuarioModel {
public function verificarUsuario($usuario, $password) {
    try {
        $pdo = connectDatabase();

        $stmt = $pdo->prepare("
            SELECT u.*, r.rol AS nombre_rol 
            FROM usuarios u
            INNER JOIN roles r ON u.idrol = r.idRol
            WHERE u.usuario = :usuario
            LIMIT 1
        ");
        $stmt->execute([
            'usuario' => $usuario
        ]);

        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);
        closeDatabase($pdo);

        // Verificación de contraseña
        if ($usuarioData && password_verify($password, $usuarioData['password'])) {
            return $usuarioData; // Login correcto, incluye nombre_rol
        } else {
            return false; // Usuario o password incorrecto
        }

    } catch (PDOException $e) {
        die("Error al verificar usuario: " . $e->getMessage());
    }
}


}