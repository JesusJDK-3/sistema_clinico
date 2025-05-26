<?php

session_start();
require_once __DIR__ . '/../../controllers/Users/EspecialistaController.php';
require_once __DIR__ . '/../../controllers/Users/AreaPsicologicaController.php';

$rol = $_SESSION['rol'] ?? '';
$idusuario = $_SESSION['idusuario'] ?? null;

$controlador = new EspecialistaController();
$areaController = new AreaPsicologicaController();
$areas = $areaController->listarAreas();
$subareas = $areaController->listarSubareas(); // Debes tener este método en tu controlador

if ($rol === 'C.General') {
    $especialistas = $controlador->listarEspecialistas();
} elseif ($rol === 'Especialista') {
    $especialistas = $controlador->obtenerEspecialistaPorUsuario($idusuario);
} else {
    header("Location: http://localhost/SistemaClinico/views/Clinica/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Especialistas</title>
    <script>
    // Especialistas
    function cargarEspecialista(esp) {
        document.getElementById('formEspecialista').action = "../../controllers/Users/editarEspecialista.php";
        document.getElementById('form_titulo').innerText = "Editar Especialista";
        document.getElementById('btn_guardar').innerText = "Editar";
        document.getElementById('edit_id').value = esp.idespecialista;
        document.getElementById('nombres').value = esp.nombres;
        document.getElementById('apellidos').value = esp.apellidos;
        document.getElementById('dni').value = esp.dni;
        document.getElementById('telefono').value = esp.telefono;
        document.getElementById('correo').value = esp.correo;
        document.getElementById('idarea').value = esp.idarea;
        mostrarSubarea();
        if (esp.idarea == 2) { // Psicológica
            document.getElementById('subarea_div').style.display = 'inline';
            document.getElementById('idsubarea').value = esp.idsubarea;
        } else {
            document.getElementById('subarea_div').style.display = 'none';
        }
    }
    function mostrarSubarea() {
        var area = document.getElementById('idarea').value;
        if (area == 2) {
            document.getElementById('subarea_div').style.display = 'inline';
        } else {
            document.getElementById('subarea_div').style.display = 'none';
        }
    }
    function limpiarFormulario() {
        document.getElementById('formEspecialista').action = "../../controllers/Users/agregarEspecialista.php";
        document.getElementById('form_titulo').innerText = "Agregar Especialista";
        document.getElementById('btn_guardar').innerText = "Agregar";
        document.getElementById('edit_id').value = "";
        document.getElementById('nombres').value = "";
        document.getElementById('apellidos').value = "";
        document.getElementById('dni').value = "";
        document.getElementById('telefono').value = "";
        document.getElementById('correo').value = "";
        document.getElementById('idarea').value = "";
        document.getElementById('idsubarea').value = "";
        document.getElementById('subarea_div').style.display = 'none';
    }

    // Áreas psicológicas
    function cargarArea() {
        var select = document.getElementById('area_select');
        var idarea = select.value;
        var areas = <?php echo json_encode($areas); ?>;
        var subareas = <?php echo json_encode($subareas); ?>;
        if (idarea === "nueva") {
            document.getElementById('area_edicion').style.display = 'block';
            document.getElementById('idarea').value = '';
            document.getElementById('nombre_area').value = '';
            document.getElementById('nombre_subarea').value = '';
            document.getElementById('btn_deshabilitar').style.display = 'none';
        } else if (idarea) {
            document.getElementById('area_edicion').style.display = 'block';
            document.getElementById('idarea').value = idarea;
            document.getElementById('nombre_area').value = areas.find(a => a.idarea == idarea).area;
            let sub = subareas.find(s => s.idarea == idarea);
            document.getElementById('nombre_subarea').value = sub ? sub.subarea : '';
            document.getElementById('btn_deshabilitar').style.display = 'inline';
        } else {
            document.getElementById('area_edicion').style.display = 'none';
        }
    }
    function limpiarArea() {
        document.getElementById('area_select').value = '';
        document.getElementById('area_edicion').style.display = 'none';
    }
    </script>
</head>
<body>
    <h1>Especialistas</h1>

    <?php if ($rol === 'C.General'): ?>
        <h2 id="form_titulo">Agregar Especialista</h2>
        <form method="POST" action="../../controllers/Users/agregarEspecialista.php" id="formEspecialista">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="nombres" id="nombres" placeholder="Nombres" required>
            <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required>
            <input type="text" name="dni" id="dni" placeholder="DNI" required>
            <input type="text" name="telefono" id="telefono" placeholder="Teléfono">
            <input type="email" name="correo" id="correo" placeholder="Correo" required>
            <select name="idarea" id="idarea" onchange="mostrarSubarea()" required>
                <option value="">Seleccione área</option>
                <?php foreach ($areas as $area): ?>
                    <option value="<?php echo $area['idarea']; ?>"><?php echo htmlspecialchars($area['area']); ?></option>
                <?php endforeach; ?>
            </select>
            <span id="subarea_div" style="display:none;">
                <select name="idsubarea" id="idsubarea">
                    <option value="1">Conductual</option>
                </select>
            </span>
            <button type="submit" id="btn_guardar">Agregar</button>
            <button type="button" onclick="limpiarFormulario()">Limpiar</button>
        </form>

        <hr>
        <h2>Gestión de Áreas Psicológicas</h2>
        <form id="formArea" method="POST" action="../../controllers/Users/AreaPsicologicaController.php">
            <label for="area_select">Seleccionar área:</label>
            <select id="area_select" name="area_select" onchange="cargarArea()">
                <option value="">-- Seleccione un área --</option>
                <?php foreach ($areas as $area): ?>
                    <option value="<?php echo $area['idarea']; ?>"><?php echo htmlspecialchars($area['area']); ?></option>
                <?php endforeach; ?>
                <option value="nueva">+ Nueva área</option>
            </select>
            <div id="area_edicion" style="display:none; margin-top:10px;">
                <input type="hidden" name="idarea" id="idarea">
                <label>Nombre área:</label>
                <input type="text" name="nombre_area" id="nombre_area">
                <label>Subárea (opcional):</label>
                <input type="text" name="nombre_subarea" id="nombre_subarea">
                <button type="submit" name="accion" value="guardar">Guardar</button>
                <button type="button" onclick="limpiarArea()">Cancelar</button>
                <button type="submit" name="accion" value="deshabilitar" id="btn_deshabilitar" style="display:none;">Deshabilitar</button>
            </div>
        </form>
    <?php endif; ?>

    <h2>Listado de Especialistas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Área</th>
            <th>Subárea</th>
            <?php if ($rol === 'C.General'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($especialistas as $esp): ?>
        <tr onclick='cargarEspecialista(<?php echo json_encode($esp); ?>)' style="cursor:pointer;">
            <td><?php echo $esp['idespecialista']; ?></td>
            <td><?php echo htmlspecialchars($esp['nombres']); ?></td>
            <td><?php echo htmlspecialchars($esp['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($esp['dni']); ?></td>
            <td><?php echo htmlspecialchars($esp['telefono']); ?></td>
            <td><?php echo htmlspecialchars($esp['correo']); ?></td>
            <td><?php echo htmlspecialchars($esp['area']); ?></td>
            <td><?php echo htmlspecialchars($esp['subarea']); ?></td>
            <?php if ($rol === 'C.General'): ?>
            <td>
                <form method="POST" action="../../controllers/Users/deshabilitarEspecialista.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $esp['idespecialista']; ?>">
                    <button type="submit">Deshabilitar</button>
                </form>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>