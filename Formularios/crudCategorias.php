<?php
    session_start();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php"); // Redirigir al formulario de inicio de sesión
        exit;
    }

    //Conexiona la bd
    require_once 'conexion.php';

    if(isset($_POST['registro'])){
        $Nombre = $_POST['Nombre'];
        $Descripcion = $_POST['Descripcion'];

        $insertardatos = "INSERT INTO tblcategorias values('','$Nombre','$Descripcion',1)";
        $ejecutarinsertar = mysqli_query($enlace, $insertardatos);
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        exit();
    }

    if(isset($_GET['eliminar'])){
        $id = $_GET['eliminar'];
        $eliminar = "UPDATE tblcategorias SET Activo = '0' WHERE IDCategoria = $id";
        $ejecutarEliminar = mysqli_query($enlace, $eliminar);
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        exit();
    }

    if(isset($_POST['actualizar'])){
        $id = $_POST['id'];
        $Nombre = $_POST['Nombre'];
        $Descripcion = $_POST['Descripcion'];

        $actualizar = "UPDATE tblcategorias SET Nombre = '$Nombre', Descripcion = '$Descripcion' WHERE IDCategoria = $id";
        $ejecutarActualizar = mysqli_query($enlace, $actualizar);
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <style>
        :root {
            --color1: #987248;
            --color2: #d7be9d;
            --color3: #5c3e20;
            --color4: #a38159;
            --color5: #c8c4b0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--color5);
            color: var(--color3);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            color: var(--color3);
            border-bottom: 2px solid var(--color2);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h1 { font-size: 24px; }
        h2 { font-size: 20px; margin-top: 30px; }

        .form-section, .list-section {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--color3);
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--color2);
            border-radius: 4px;
            background-color: var(--color5);
        }

        .form-actions, .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        button[type="submit"], button[name="registro"], button[name="actualizar"], .btn-confirm {
            background-color: var(--color1);
            color: white;
        }

        button[type="reset"], .btn-cancel {
            background-color: var(--color2);
            color: var(--color3);
        }

        .btn-edit {
            background-color: var(--color4);
            color: white;
        }

        .btn-delete {
            background-color: #d9534f;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--color2);
        }

        th {
            background-color: var(--color1);
            color: white;
        }

        tr:nth-child(even) {
            background-color: var(--color5);
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 80%;
            }
            
            .form-actions, .modal-actions {
                flex-direction: column;
            }
            
            button {
                width: 100%;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>Gestión de Categorías</h1>

        <div class="text-center">
        <a href="administrar.php"><img  src="../Images/administrar.png" alt="agregar articulo" width="60" height="60"> </a>
        <h5>Administrar</h5>
        </div>

        <!-- Formulario Nueva Categoría -->
        <div class="form-section">
            <h2>Nueva Categoría</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="Nombre" placeholder="Ej. Electrónica" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <input type="text" name="Descripcion" placeholder="Ej. Productos electrónicos">
                </div>
                <div class="form-actions">
                    <button type="submit" name="registro">Agregar</button>
                    <button type="reset">Limpiar</button>
                </div>
            </form>
        </div>

        <!-- Listado de Categorías -->
        <div class="list-section">
            <h2>Listado de Categorías</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = "SELECT * FROM tblcategorias WHERE Activo = 1";
                    $resultado = mysqli_query($enlace, $consulta);
                    
                    while($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>".$fila['IDCategoria']."</td>";
                        echo "<td>".$fila['Nombre']."</td>";
                        echo "<td>".$fila['Descripcion']."</td>";
                        echo "<td class='actions'>";
                        echo "<button class='btn-edit' onclick=\"mostrarModalEditar(".$fila['IDCategoria'].", '".htmlspecialchars($fila['Nombre'], ENT_QUOTES)."', '".htmlspecialchars($fila['Descripcion'], ENT_QUOTES)."')\">Editar</button>";
                        echo "<button class='btn-delete' onclick=\"mostrarModalEliminar(".$fila['IDCategoria'].", '".htmlspecialchars($fila['Nombre'], ENT_QUOTES)."')\">Eliminar</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <h2>Editor Categoría</h2>
            <form id="formEditar" method="post">
                <input type="hidden" name="id" id="editarId">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" id="editarNombre" name="Nombre" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <input type="text" id="editarDescripcion" name="Descripcion">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="cerrarModalEditar()">Cancelar</button>
                    <button type="submit" name="actualizar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <h2>Confirmar Eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar la categoría "<span id="nombreCategoria"></span>"?</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="cerrarModalEliminar()">Cancelar</button>
                <button type="button" class="btn-confirm" onclick="confirmarEliminacion()">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let categoriaAEliminar = null;
        
        // Funciones para el modal de editar
        function mostrarModalEditar(id, nombre, descripcion) {
            document.getElementById('editarId').value = id;
            document.getElementById('editarNombre').value = nombre;
            document.getElementById('editarDescripcion').value = descripcion;
            document.getElementById('modalEditar').style.display = 'block';
        }
        
        function cerrarModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }
        
        // Funciones para el modal de eliminar
        function mostrarModalEliminar(id, nombre) {
            categoriaAEliminar = id;
            document.getElementById('nombreCategoria').textContent = nombre;
            document.getElementById('modalEliminar').style.display = 'block';
        }
        
        function cerrarModalEliminar() {
            document.getElementById('modalEliminar').style.display = 'none';
            categoriaAEliminar = null;
        }
        
        function confirmarEliminacion() {
            if (categoriaAEliminar) {
                window.location.href = '?eliminar=' + categoriaAEliminar;
            }
        }
        
        // Cerrar modales al hacer clic fuera del contenido
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalEditar')) {
                cerrarModalEditar();
            }
            if (event.target == document.getElementById('modalEliminar')) {
                cerrarModalEliminar();
            }
        }
        
        // Mostrar mensajes de éxito/error
        <?php if(isset($_GET['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Operación realizada correctamente',
                timer: 2000,
                showConfirmButton: false
            });
        <?php elseif(isset($_GET['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al realizar la operación',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>
</body>
</html>