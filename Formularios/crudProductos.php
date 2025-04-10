<?php
    session_start();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php"); // Redirigir al formulario de inicio de sesión
        exit;
    }

    // Conexión a la base de datos
    require_once 'conexion.php';

    // Función para subir imágenes
    function subirImagen($inputName) {
        if(isset($_FILES[$inputName])) {
            if($_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $directorioDestino = "../Imagenes/";
                if(!is_dir($directorioDestino)) {
                    mkdir($directorioDestino, 0777, true);
                }

                $nombreArchivo = uniqid() . '_' . basename($_FILES[$inputName]["name"]);
                $rutaCompleta = $directorioDestino . $nombreArchivo;

                // Verificar si es una imagen
                $check = getimagesize($_FILES[$inputName]["tmp_name"]);
                if($check !== false) {
                    if(move_uploaded_file($_FILES[$inputName]["tmp_name"], $rutaCompleta)) {
                        return "Imagenes/" . $nombreArchivo;
                    } else {
                        return null;
                    }
                }
            } elseif($_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE) {
                // Hubo un error al subir el archivo
                return null;
            }
        }
        return null;
    }

    // Procesar registro de nuevo producto
    if(isset($_POST['registro'])){
        $Nombre = mysqli_real_escape_string($enlace, $_POST['Nombre']);
        $Descripcion = mysqli_real_escape_string($enlace, $_POST['Descripcion']);
        $Precio = number_format((float)$_POST['Precio'], 2, '.', ''); // Asegúrate de que Precio tenga dos decimales
        // Subir imágenes
        $Img1 = subirImagen('Img1') ?? '';
        $Img2 = subirImagen('Img2') ?? '';
        $Img3 = subirImagen('Img3') ?? '';

        $insertardatos = "INSERT INTO tblproductos VALUES('','$Nombre','$Descripcion', '$Precio', '$Img1', '$Img2', '$Img3',1)";
        $ejecutarinsertar = mysqli_query($enlace, $insertardatos);

        if($ejecutarinsertar) {
            header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        } else {
            header("Location: ".$_SERVER['PHP_SELF']."?error=1");
        }
        exit();
    }

    // Procesar eliminación de producto
    if(isset($_GET['eliminar'])){
        $id = intval($_GET['eliminar']);
        $eliminar = "UPDATE tblproductos SET Activo = '0' WHERE IDProducto = $id";
        $ejecutarEliminar = mysqli_query($enlace, $eliminar);

        if($ejecutarEliminar) {
            header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        } else {
            header("Location: ".$_SERVER['PHP_SELF']."?error=1");
        }
        exit();
    }

    // Procesar actualización de producto
    if(isset($_POST['actualizar'])){
        $id = intval($_POST['id']);
        $Nombre = mysqli_real_escape_string($enlace, $_POST['Nombre']);
        $Descripcion = mysqli_real_escape_string($enlace, $_POST['Descripcion']);
        $Precio = number_format((float)$_POST['Precio'], 2, '.', ''); // Capturar y formatear el Precio

        // Obtener las imágenes existentes primero
        $consulta = "SELECT Img1, Img2, Img3 FROM tblproductos WHERE IDProducto = $id";
        $resultado = mysqli_query($enlace, $consulta);
        $fila = mysqli_fetch_assoc($resultado);

        // Subir nuevas imágenes si se proporcionaron
        $Img1 = !empty($_FILES['Img1']['name']) ? (subirImagen('Img1') ?? $fila['Img1']) : $fila['Img1'];
        $Img2 = !empty($_FILES['Img2']['name']) ? (subirImagen('Img2') ?? $fila['Img2']) : $fila['Img2'];
        $Img3 = !empty($_FILES['Img3']['name']) ? (subirImagen('Img3') ?? $fila['Img3']) : $fila['Img3'];

        // Actualizar el producto en la base de datos, incluyendo el Precio
        $actualizar = "UPDATE tblproductos SET Nombre = '$Nombre', Descripcion = '$Descripcion', Precio = '$Precio', Img1 = '$Img1', Img2 = '$Img2', Img3 = '$Img3' WHERE IDProducto = $id";
        $ejecutarActualizar = mysqli_query($enlace, $actualizar);

        if($ejecutarActualizar) {
            header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        } else {
            header("Location: ".$_SERVER['PHP_SELF']."?error=1");
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA | crudProductos</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
    <!-- Incluye Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

        .table-container {
            max-width: 100%;
            overflow-x: auto;
            margin-top: 15px;
            border: 1px solid var(--color2);
            border-radius: 5px;
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
            margin-bottom: 5px;
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

        .form-group input, .form-group textarea {
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

        .preview-img {
            max-width: 50px;
            max-height: 50px;
            display: block;
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
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            min-width: 300px;
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

        .form-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group small {
            font-size: 0.9em;
            color: #666;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
        -moz-appearance: textfield; /* Para Firefox */
        appearance: textfield;      /* Para otros navegadores */
    }

</style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <h1>Gestión de Productos</h1>

        <div class="text-center">
            <a href="administrar.php"><img src="../img/administrar.png" alt="agregar articulo" width="60" height="60"></a>
            <h5>Administrar</h5>
        </div>

        <!-- Formulario Nuevo Producto -->
        <div class="form-section">
            <h2>Nuevo Producto</h2>
            <form id="productForm" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="Nombre" placeholder="Ej. Jabon" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea name="Descripcion" placeholder="Ej. Jabon de coco" required></textarea>
                </div>

                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="Precio" placeholder="100.00" step="0.01" min="0" required>
                    <small id="error-msg" style="color: red; display: none;">Ingrese un número válido.</small>
                </div>
                <div class="form-group">
                    <label>Imagen 1:</label>
                    <input type="file" name="Img1" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Imagen 2:</label>
                    <input type="file" name="Img2" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Imagen 3:</label>
                    <input type="file" name="Img3" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" name="registro">Agregar</button>
                    <button type="reset">Limpiar</button>
                </div>
            </form>
        </div>

        <!-- Listado de Productos -->
        <div class="list-section table-container">
            <h2>Listado de Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Img 1</th>
                        <th>Img 2</th>
                        <th>Img 3</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = "SELECT * FROM tblproductos WHERE Activo = 1";
                    $resultado = mysqli_query($enlace, $consulta);

                    while($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>".$fila['IDProducto']."</td>";
                        echo "<td>".htmlspecialchars($fila['Nombre'])."</td>";
                        echo "<td>".htmlspecialchars($fila['Descripcion'])."</td>";
                        echo "<td>".htmlspecialchars($fila['Precio'])."</td>";
                        echo "<td>".($fila['Img1'] ? "<img src='../".$fila['Img1']."' class='preview-img'>" : "")."</td>";
                        echo "<td>".($fila['Img2'] ? "<img src='../".$fila['Img2']."' class='preview-img'>" : "")."</td>";
                        echo "<td>".($fila['Img3'] ? "<img src='../".$fila['Img3']."' class='preview-img'>" : "")."</td>";
                        echo "<td class='actions'>";
                        echo "<button class='btn-edit' onclick=\"mostrarModalEditar(".$fila['IDProducto'].", '".htmlspecialchars($fila['Nombre'], ENT_QUOTES)."', '".htmlspecialchars($fila['Descripcion'], ENT_QUOTES)."', '".$fila['Precio']."', '".$fila['Img1']."', '".$fila['Img2']."', '".$fila['Img3']."')\">Editar</button>";
                        echo "<button class='btn-delete' onclick=\"mostrarModalEliminar(".$fila['IDProducto'].", '".htmlspecialchars($fila['Nombre'], ENT_QUOTES)."')\">Eliminar</button>";
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
            <h2>Editar Producto</h2>
            <form id="formEditar" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editarId">
                <div class="form-container">
                    <div class="form-column">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" id="editarNombre" name="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción:</label>
                            <textarea id="editarDescripcion" name="Descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editarPrecio">Precio:</label>
                            <input type="number" id="editarPrecio" name="Precio" placeholder="100.00" step="0.01" min="0" required>
                            <small id="error-msg-editar" style="color: red; display: none;">Ingrese un número válido.</small>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label>Imagen 1:</label>
                            <input type="file" id="editarImg1" name="Img1" accept="image/*">
                            <small id="currentImg1"></small>
                        </div>
                        <div class="form-group">
                            <label>Imagen 2:</label>
                            <input type="file" id="editarImg2" name="Img2" accept="image/*">
                            <small id="currentImg2"></small>
                        </div>
                        <div class="form-group">
                            <label>Imagen 3:</label>
                            <input type="file" id="editarImg3" name="Img3" accept="image/*">
                            <small id="currentImg3"></small>
                        </div>
                    </div>
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
            <p>¿Estás seguro de que deseas eliminar el producto "<span id="nombreProducto"></span>"?</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="cerrarModalEliminar()">Cancelar</button>
                <button type="button" class="btn-confirm" onclick="confirmarEliminacion()">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let productoAEliminar = null;

        // Funciones para el modal de editar
        function mostrarModalEditar(id, nombre, descripcion, precio, img1, img2, img3) {
            document.getElementById('editarId').value = id;
            document.getElementById('editarNombre').value = nombre;
            document.getElementById('editarDescripcion').value = descripcion;
            document.getElementById('editarPrecio').value = precio; // Establecer el valor del precio

            // Mostrar información de imágenes actuales
            document.getElementById('currentImg1').textContent = img1 ? 'Actual: ' + img1 : 'Sin imagen';
            document.getElementById('currentImg2').textContent = img2 ? 'Actual: ' + img2 : 'Sin imagen';
            document.getElementById('currentImg3').textContent = img3 ? 'Actual: ' + img3 : 'Sin imagen';

            document.getElementById('modalEditar').style.display = 'block';
        }

        document.getElementById('editarPrecio').addEventListener('blur', function() {
            // Formatea el valor a dos decimales cuando el campo pierde el foco
            this.value = parseFloat(this.value).toFixed(2);
        });

        document.getElementById('formEditar').addEventListener('submit', function(event) {
            var precio = parseFloat(document.getElementById('editarPrecio').value);
            if (precio < 0) {
                event.preventDefault(); // Evita que el formulario se envíe
                document.getElementById('error-msg-editar').style.display = 'inline';
            } else {
                document.getElementById('error-msg-editar').style.display = 'none';
            }
        });

        function cerrarModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        // Funciones para el modal de eliminar
        function mostrarModalEliminar(id, nombre) {
            productoAEliminar = id;
            document.getElementById('nombreProducto').textContent = nombre;
            document.getElementById('modalEliminar').style.display = 'block';
        }

        function cerrarModalEliminar() {
            document.getElementById('modalEliminar').style.display = 'none';
            productoAEliminar = null;
        }

        function confirmarEliminacion() {
            if (productoAEliminar) {
                window.location.href = '?eliminar=' + productoAEliminar;
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

        document.getElementById('precio').addEventListener('blur', function() {
            // Formatea el valor a dos decimales cuando el campo pierde el foco
            this.value = parseFloat(this.value).toFixed(2);
        });

        document.getElementById('productForm').addEventListener('submit', function(event) {
            var precio = parseFloat(document.getElementById('precio').value);
            if (precio < 0) {
                event.preventDefault(); // Evita que el formulario se envíe
                document.getElementById('error-msg').style.display = 'inline';
            } else {
                document.getElementById('error-msg').style.display = 'none';
            }
        });

        // Mostrar mensajes de éxito/error
        <?php if(isset($_GET['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Operación realizada correctamente',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Limpiar parámetros de la URL
                history.replaceState(null, null, window.location.pathname);
            });
        <?php elseif(isset($_GET['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al realizar la operación',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Limpiar parámetros de la URL
                history.replaceState(null, null, window.location.pathname);
            });
        <?php endif; ?>
    </script>
</body>
</html>
