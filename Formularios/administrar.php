<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir al formulario de inicio de sesión
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA | Administrar</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
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
                <a href="administrar.php" class="navbar-brand">KITA</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <!--  <li class="active"><a href="index.php">Inicio<span class="sr-only">(current)</span></a></li>-->
                    <li><a href="crudProductos.php">Productos</a></li>
                    <li><a href="crudCategorias.php">Categorías</a></li>
                    <li><a href="logout.php">Salir</a></li>
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


    <section class="seccion">
    <div class="content">
        <?php
        echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . "</h1>";
        echo "<p>Esta es la página de administración.</p>";
        echo '<a href="logout.php" class="btn btn-primary">Cerrar sesión</a>';
        ?>

        <div class="container-agregar">
            <div class="img-agregar">
                <a href="crudProductos.php"><img src="../img/anadir-articulo.png" alt="Administrar producto" width="80" height="80"></a>
                <h5>Productos</h5>
            </div>
            <div class="img-agregar">
                <a href="crudCategorias.php"><img src="../img/categorias.png" alt="Administrar categoria" width="80" height="80"></a>
                <h5>Categorías</h5>
            </div>
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
                                    <dt><a href="crudProductos.php">Productos</a></dt>
                                    <dt><a href="crudCategorias.php">Categorías</a></dt>
                                    <dt><a href="logout.php">Salir</a></dt>
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
        <!-- Slick Carousel JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.js"></script>
</body>

</html>