<?php
// Quita o comenta esta línea al inicio del archivo
// session_start();
require_once __DIR__ . '/../../controllers/Specialist/EspecialistaController.php';
require_once __DIR__ . '/../../controllers/Area/AreaPsicologicaController.php';

$rol = $_SESSION['rol'] ?? '';
$idusuario = $_SESSION['idusuario'] ?? null;

$controlador = new EspecialistaController();
$areaController = new AreaPsicologicaController();
$areas = $areaController->listarAreas();
$subareas = $areaController->listarSubareas();

if ($rol === 'C.General') {
    $especialistas = $controlador->listarEspecialistas();
} elseif ($rol === 'Especialista') {
    $especialistas = $controlador->obtenerEspecialistaPorUsuario($idusuario);
} else {
    header("Location: http://localhost/SistemaClinico/views/Clinica/login.php");
    exit;
}
?>
<script>
// Función para abrir el modal
function abrirModal() {
    document.getElementById('modalEspecialista').style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevenir scroll del body
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modalEspecialista').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restaurar scroll del body
}

// Función para nuevo especialista
function nuevoEspecialista() {
    abrirModal();
}

function cargarEspecialista(esp) {
    document.getElementById('formEspecialista').action = "../../controllers/Specialist/editarEspecialista.php";
    document.getElementById('form_titulo').innerText = "Editar Especialista";
    document.getElementById('btn_guardar').innerText = "Editar";
    document.getElementById('edit_id').value = esp.idespecialista;
    document.getElementById('nombres').value = esp.nombres;
    document.getElementById('apellidos').value = esp.apellidos;
    document.getElementById('dni').value = esp.dni;
    document.getElementById('telefono').value = esp.telefono;
    document.getElementById('correo').value = esp.correo;
    document.getElementById('idarea_esp').value = esp.idarea;
    mostrarSubarea();
    if (esp.idarea == 2) {
        document.getElementById('subarea_div').style.display = 'block';
        document.getElementById('idsubarea').value = esp.idsubarea;
    } else {
        document.getElementById('subarea_div').style.display = 'none';
    }
    document.querySelectorAll('.specialists-table tbody tr').forEach(row => {
        row.classList.remove('row-selected');
    });
    event.currentTarget.classList.add('row-selected');
    
    // Abrir modal para editar
    abrirModal();
}

// Función específica para el botón de editar
function editarEspecialista(esp, event) {
    event.stopPropagation(); // Evitar que se active el click de la fila
    cargarEspecialista(esp);
}

function mostrarSubarea() {
    var area = document.getElementById('idarea_esp').value;
    var subareaDiv = document.getElementById('subarea_div');
    var subareaSelect = document.getElementById('idsubarea');
    subareaSelect.innerHTML = '';
    var subareas = <?php echo json_encode($subareas); ?>;
    if (area) {
        var subareasFiltradas = subareas.filter(function(s) {
            return s.idarea == area;
        });
        if (subareasFiltradas.length > 0) {
            subareasFiltradas.forEach(function(sub) {
                var opt = document.createElement('option');
                opt.value = sub.idsubarea;
                opt.text = sub.subarea;
                subareaSelect.appendChild(opt);
            });
            subareaDiv.style.display = 'block';
        } else {
            subareaDiv.style.display = 'none';
        }
    } else {
        subareaDiv.style.display = 'none';
    }
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('modalEspecialista');
    if (event.target == modal) {
        cerrarModal();
    }
}
</script>

<!-- container 2 -->
<div class="header">
    
</div>
<div class="content">
    <!-- Header -->
    <div class="header-search">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Buscar paciente por nombre, email, celular, DNI/CURP, registro médico y/o monedero electronico">
            <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color:rgb(180, 184, 185);"></i>
        </div>
        <div class="user-info">
            <?php if ($rol === 'C.General'): ?>
                <button class="btn-new" onclick="nuevoEspecialista()">
                    <i class="fas fa-plus"></i> Nuevo registro
                </button>
            <?php endif; ?>
        </div>
    </div>
    

    <!-- Modal para Formulario de Especialista -->
    <?php if ($rol === 'C.General'): ?>
        <div id="modalEspecialista" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="form_titulo">Agregar Especialista</h2>
                    <span class="close" onclick="cerrarModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../controllers/Specialist/agregarEspecialista.php" id="formEspecialista">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" name="nombres" id="nombres" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" name="dni" id="dni" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="idarea_esp">Área de Especialidad</label>
                                <select name="idarea" id="idarea_esp" class="form-control" onchange="mostrarSubarea()" required>
                                    <option value="">Seleccione área</option>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?php echo $area['idarea']; ?>"><?php echo htmlspecialchars($area['area']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div id="subarea_div" style="display:none;">
                            <div class="form-group">
                                <label for="idsubarea">Subárea</label>
                                <select name="idsubarea" id="idsubarea" class="form-control"></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" form="formEspecialista" class="btn btn-primary" id="btn_guardar">Agregar</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tabla de Especialistas -->
<div class="table-container">
    <table class="specialists-table">
        <thead>
            <tr>
                <th>Nombres y Apellidos</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Correo</th>
                <th>AREA Y SUBAREA</th>
                <?php if ($rol === 'C.General'): ?>
                    <th class="actions-col">Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($especialistas as $esp): ?>
            <tr onclick='cargarEspecialista(<?php echo json_encode($esp); ?>)' class="table-row">
                <td class="name-col">
                    <div class="name-with-avatar">
                        <div class="user-avatar">
                            <?php 
                            $iniciales = strtoupper(substr($esp['nombres'], 0, 1) . substr($esp['apellidos'], 0, 1));
                            echo $iniciales;
                            ?>
                        </div>
                        <div class="user-name">
                            <?php echo htmlspecialchars($esp['nombres'] . ' ' . $esp['apellidos']); ?>
                        </div>
                    </div>
                </td>
                <td class="dni-col"><?php echo htmlspecialchars($esp['dni']); ?></td>
                <td class="contact-col"><?php echo htmlspecialchars($esp['telefono']); ?></td>
                <td class="contact-col"><?php echo htmlspecialchars($esp['correo']); ?></td>
                <td class="role-col">
                    <span class="role-badge">
                        <?php echo htmlspecialchars($esp['area']); ?>
                        <?php if (!empty($esp['subarea'])): ?>
                            <small class="subarea-text"><?php echo htmlspecialchars($esp['subarea']); ?></small>
                        <?php endif; ?>
                    </span>
                </td>
                <?php if ($rol === 'C.General'): ?>
                <td class="actions-col">
                    <div class="action-buttons">
                        <button type="button" 
                                class="action-btn edit-btn" 
                                onclick="editarEspecialista(<?php echo htmlspecialchars(json_encode($esp)); ?>, event)"
                                title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="../../controllers/Specialist/deshabilitarEspecialista.php" style="display:inline;" 
                              onsubmit="event.stopPropagation();">
                            <input type="hidden" name="id" value="<?php echo $esp['idespecialista']; ?>">
                            <button type="submit" class="action-btn delete-btn" title="Eliminar" 
                                    onclick="event.stopPropagation();">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>