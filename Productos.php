<?php
//Conexiona la bd
require_once 'conexion.php';

$sql = "SELECT * FROM tblproductos WHERE Activo = 1";
$resultado = mysqli_query($enlace, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA Te Cuida</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/stilo.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
    <style>
        .card-custom {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-custom img {
            object-fit: cover;
            height: 200px; /* Ajusta la altura de la imagen */
        }
        .card-custom .card-body {
            padding: 15px;
        }
        .card-custom .card-title {
            font-size: 1.1em;
            margin-bottom: 10px;
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
                </ul>
            </div>
        </div>
    </nav>
    
    <section id="productos" class="seccion">
        <div class="container">
            <h2 class="titulo-seccion">Nuestros Productos</h2>

            <div class="container">
                <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-left">
                    <?php
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($producto = mysqli_fetch_assoc($resultado)) {
                            echo '<div class="col">';
                            echo '<div class="card card-custom h-100">';
                            echo '<div class="overflow-hidden" method="post">';
                            echo '<img src="' . $producto['Img1'] . '" class="card-img-top" alt="' . $producto['Img1'] . '" style="width: 100%;">';
                            echo '</div>';
                            echo '<div class="card-body d-flex flex-column justify-content-between">';
                            echo '<h4 class="card-title">Código ' . $producto['IDProducto'] . '</h4>';
                            echo '<h4 class="card-title">' . $producto['Nombre'] . '</h4>';
                            echo '<h4 class="card-title">' . $producto['Descripcion'] . '</h4>';
                            echo '<p class="card-text"></p>';

                            echo '<form action="/detalleproductos" method="post">';
                            echo '<input type="hidden" name="txtID" value="' . $producto['IDProducto'] . '">';
                            echo '<button type="submit" class="btn btn-success">Comprar</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No se encontraron productos.";
                    }
                    ?>
                </div>
            </div>
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

<?php mysqli_close($enlace); ?>