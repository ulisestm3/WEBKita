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
        // Credenciales inválidas
        echo "<script>alert('Usuario o contraseña incorrectos.');</script>";
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
    <title>KITALOGIN</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/stilo.css" rel="stylesheet" type="text/css">
    <style>
        .login-form {
            width: 350px;
            margin: 100px auto 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form .btn-success {
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default menu-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="../index.html" class="navbar-brand">KITA</a>
            </div>
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../index.html">Inicio</a></li>
                    <li><a href="../QuienesSomos.html">Quiénes Somos</a></li>
                    <li><a href="../Productos.php">Productos</a></li>
                    <li><a href="../PropositoYValores.html">Propósito y Valores</a></li>
                    <li><a href="../Contactenos.html">Contáctenos</a></li>
                    <li><a href="../mostrarcarrito.php">Carrito (<?php echo (empty($_SESSION['CARRITO'])?0:count($_SESSION['CARRITO']));?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

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

    <footer>
        <section class="pie01">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Mapa del Sitio</h4>
                        <dl>
                            <dt><a href="quienessomos.html">Quiénes Somos</a></dt>
                            <dt><a href="PropositoYValores.html">La Empresa</a></dt>
                            <dt><a href="vehiculos.html">Vehículos</a></dt>
                            <dt><a href="contactenos.html">Contáctenos</a></dt>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h4>Datos de Contacto</h4>
                        <address>
                            Dirección: Semáforos de Villa Fontana<br>
                            <abbr title="phone">Teléfono: </abbr>(+505) 2234-5678<br>
                            E-mail:<a href="mailto:info@kia.com.ni"> info@kia.com.ni</a><br>
                            Horario de atención: 8:00 a.m - 5:00 p.m<br>
                            Facebook ׀ Twitter
                        </address>
                    </div>
                </div>
            </div>
        </section>
        <section class="pie02">
            <div class="container">
                &copy; Copyright 2025 Kita
            </div>
        </section>
    </footer>

    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>
</html>
<?php mysqli_close($enlace); ?>