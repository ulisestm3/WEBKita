<?php
	include 'carrito.php';

    //Conexiona la bd
    require_once 'conexion.php';

    if (!$enlace) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    
    // Procesar el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $claveTransaccion = $_POST['claveTransaccion'];
    
        // Escapar entradas para prevenir inyecciones SQL
        $claveTransaccion = mysqli_real_escape_string($enlace, $claveTransaccion);
    
        // Consulta para verificar las credenciales
        $sql = "SELECT * FROM tblventas WHERE ClaveTransaccion = ?";
        $stmt = $enlace->prepare($sql);
        $stmt->bind_param("s", $claveTransaccion);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            echo '
            <form id="redirigirFacturacion" action="facturacion.php" method="post" style="display:none;">
                <input type="hidden" name="claveTransaccion" value="' . htmlspecialchars($claveTransaccion) . '">
            </form>
            <script>
                document.getElementById("redirigirFacturacion").submit();
            </script>
            ';
            exit;
        }
        else {
            echo '
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
                    Revisar código. No existe el código en nuestros registros.
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>
        
            <script>
            window.onload = function() {
                $("#codigoModal").modal("show");
            };
            </script>
            ';
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
    <title>KITA | Consultar</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/stilo.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
    <style>
        .cosulta-form {
            width: 450px;
            margin: 100px auto 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cosulta-form .form-group {
            margin-bottom: 20px;
        }

        .cosulta-form .btn-success {
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
                <a href="index.html" class="navbar-brand">KITA</a>
            </div>
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="QuienesSomos.html">Quiénes Somos</a></li>
                    <li><a href="Productos.php">Productos</a></li>
                    <li><a href="PropositoYValores.html">Proposito Y Valores</a></li>
                    <li><a href="Contactenos.html">Contáctenos</a></li>
                    <li><a href="Formularios/login.php">Administrar</a></li>
                    <li><a href="mostrarcarrito.php">Carrito (<?php echo (empty($_SESSION['CARRITO'])?0:count($_SESSION['CARRITO']));?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <section id="consulta" class="seccion">
    <div class="cosulta-form">
        <h2>Consulta de Compra</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="claveTransaccion">Código de transacción</label>
                <input type="text" class="form-control" id="claveTransaccion" name="claveTransaccion" required>
            </div>
            <button type="submit" class="btn btn-success">Consultar</button>
        </form>
    </div>
    </section>
    <footer>
        <section class="pie01">
            <div class="container">
                <div class="row" text align="left">
                    <div class="col-md-6">
                        <h4>Mapa del Sitio</h4>
                        <dl>
                            <dl>
                                <dt><a href="quienessomos.html">Quiénes Somos</a></dt>
                                <dt><a href="PropositoYValores.html">La Empresa</a></dt>
                                <dt><a href="Productos.html">Vehículos</a></dt>
                                <dt><a href="contactenos.html">Contáctenos</a></dt>
                            </dl>
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
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>