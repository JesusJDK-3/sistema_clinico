<?php
require_once __DIR__ . '/../../models/Users/UserModel.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $modelo = new UsuarioModel();
    $datosUsuario = $modelo->verificarUsuario($usuario, $password);

    if ($datosUsuario) {
        // Login correcto, guardamos en sesión
        $_SESSION['idusuario']   = $datosUsuario['idusuario'];
        $_SESSION['usuario']     = $datosUsuario['usuario'];
        $_SESSION['nombre']      = $datosUsuario['nombres'] . ' ' . $datosUsuario['apellidos'];
        $_SESSION['rol']         = $datosUsuario['nombre_rol'];

        
      
        header("Location: http://localhost/SistemaClinico/views/Clinica/principal.php");
        exit;
    } else {
        // Error de login
        $_SESSION['error_login'] = 'Usuario o contraseña incorrectos.';
        header("Location: http://localhost/SistemaClinico/views/Clinica/login.php");
        exit;
    }
} else {
    // Si acceden directamente sin POST
  header("Location: http://localhost/SistemaClinico/views/Clinica/login.php");
    exit;
}
