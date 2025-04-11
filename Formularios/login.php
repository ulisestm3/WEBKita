<?php
include '../carrito.php';

//session_start(); // Inicia la sesión

//Conexiona la bd
require_once 'conexion.php';

if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['txtUsuario'];
    $password = $_POST['txtPassword'];

    // Escapar entradas para prevenir inyecciones SQL
    $usuario = mysqli_real_escape_string($enlace, $usuario);
    $password = mysqli_real_escape_string($enlace, $password);

    // Consulta para verificar las credenciales
    $sql = "SELECT * FROM tblusuarios WHERE Usuario = ? AND Password = ?";
    $stmt = $enlace->prepare($sql);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Credenciales válidas
        $_SESSION['usuario'] = $usuario; // Guardar el nombre de usuario en la sesión
        header("Location: administrar.php"); // Redirigir al panel de administración
        exit;
    } else {
        $mostrarModal = true;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA | Login</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <!-- Incluye Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- INICIO DEL MENU DE NAVEGACIÓN -->
    <nav class="navbar navbar-default menu-fixed">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="../index.php" class="navbar-brand">KITA</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../nosotros.php">Nosotros</a></li>
                    <li><a href="../productos.php">Productos</a></li>
                    <li><a href="../consulta.php">Consulta</a></li>
                    <li><a href="../contactenos.php">Contáctenos</a></li>
                    <li><a href="login.php">Administrar</a></li>
                    <li>
                        <a href="../mostrarcarrito.php">
                            <span class="cart-icon">
                                <i class="fas fa-shopping-cart"></i> <!-- Icono de carrito -->
                                <span class="cart-count"><?php echo (empty($_SESSION['CARRITO']) ? 0 : count($_SESSION['CARRITO'])); ?></span> <!-- Contador -->
                            </span>
                        </a>
                    </li>
            </div>
        </div>
    </nav>
    <!-- FIN DEL MENÚ DE NAVEGACIÓN -->

    <!-- INICIO DEL SLIDER DEL BANNER -->
    <div id="carousel1" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel1" data-slide-to="0" class="active"></li>
            <li data-target="#carousel1" data-slide-to="1"></li>
            <li data-target="#carousel1" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="../img/pic.jpg" alt="First slide image" class="d-block w-100">
                <div class="carousel-caption">
                    <h3></h3>
                    <p></p>
                </div>
            </div>

            <div class="item">
                <img src="../img/pic1.jpg" alt="Second slide image" class="d-block w-100">
                <div class="carousel-caption">
                    <h3></h3>
                    <p></p>
                </div>
            </div>

            <div class="item">
                <img src="../img/pic4.png" alt="Third slide image" class="d-block w-100">
                <div class="carousel-caption">
                    <h3></h3>
                    <p></p>
                </div>
            </div>
        </div>

        <a class="left carousel-control" href="#carousel1" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel1" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- FIN DEL SLIDER DEL BANNER -->

    <!--CONTENIDO DE LA PÁGINA-->

    <section>
        <div class="login-form">
            <h2>Inicio de Sesión</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="txtUsuario">Usuario</label>
                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" required>
                </div>
                <div class="form-group">
                    <label for="txtPassword">Contraseña</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" required>
                </div>
                <button type="submit" class="btn btn-success">Entrar</button>
            </form>
        </div>
    </section>

    <!--FIN DEL CONTENIDO DE LA PÁGINA-->

    <!-- INICIO PIE DE PÁGINA -->
    <footer>
        <!--Sección 01-->
        <section class="pie01">
            <div class="container">
                <div class="row" text align="left"> <!--Inicio de la 1ra Fila-->
                    <!--Mapa del Sitio-->
                    <div class="col-md-6">
                        <h4>Mapa del Sitio</h4>
                        <dl>
                            <dl>
                                <dt><a href="../index.php">Inicio</a></dt>
                                <dt><a href="../nosotros.php">Nosotros</a></dt>
                                <dt><a href="../productos.php">Productos</a></dt>
                                <dt><a href="../consulta.php">Consulta</a></dt>
                                <dt><a href="../contactenos.php">Contáctenos</a></dt>
                                <dt><a href="login.php">Administrar</a></dt>
                            </dl>
                        </dl>
                    </div>
                    <!--Datos de Contactos-->
                    <div class="col-md-6">
                        <h4>Datos de Contacto</h4>
                        <address>
                            Dirección: Semáforos de Villa Fontana<br>
                            Teléfono: (+505) 2234-5678<br>
                            E-mail: <a href="mailto:ventas.jabonkita@gmail.com">ventas.jabonkita@gmail.com</a><br>
                            Horario de atención: 8:00 a.m - 5:00 p.m<br>
                            Facebook ׀ Twitter
                        </address>
                    </div>
                </div><!--Cierre de la Fila-->
            </div>
        </section>

        <!--Sección 02-->
        <section class="pie02" align="center">
            <div class="container">
                &copy; Copyright 2025 Kita
            </div>
        </section>
    </footer>
    <!-- FIN PIE DE PÁGINA -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.js"></script>

    <?php if (isset($mostrarModal) && $mostrarModal): ?>
        <style>
        /* Centramos el modal verticalmente */
        .modal-dialog {
            margin-top: 15%;
            width: 350px;
        }
        </style>

        <!-- Modal Bootstrap 3 -->
        <div class="modal fade" id="codigoModal" tabindex="-1" role="dialog" aria-labelledby="codigoModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #f2dede; border-bottom: 1px solid #ebccd1;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="codigoModalLabel" style="color: #a94442;">Aviso</h4>
              </div>
              <div class="modal-body" style="color: #a94442;">
                Lo sentimos las credenciales ingresadas no son correctas.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
          </div>
        </div>

        <script>
        jQuery(document).ready(function() {
            jQuery("#codigoModal").modal("show");
        });
        </script>
    <?php endif; ?>
</body>

</html>

<?php mysqli_close($enlace); ?>
