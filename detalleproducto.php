<?php
include 'carrito.php';
// Conexión a la base de datos
require_once 'conexion.php';

// Verificar si se ha enviado el ID del producto
if (isset($_POST['txtID'])) {
    $idProducto = $_POST['txtID'];

    // Consulta para obtener los detalles del producto específico
    $sql = "SELECT * FROM tblproductos WHERE IDProducto = $idProducto AND Activo = 1";
    $resultado = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        echo "No se encontró el producto.";
        exit;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA | DetalleProducto</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
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
				<a href="index.php" class="navbar-brand">KITA</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="defaultNavbar1">
				<ul class="nav navbar-nav navbar-right">
					<!--  <li class="active"><a href="index.php">Inicio<span class="sr-only">(current)</span></a></li>-->
					<li><a href="index.php">Inicio</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
					<li><a href="productos.php">Productos</a></li>
					<li><a href="consulta.php">Consulta</a></li>
					<li><a href="contactenos.php">Contáctenos</a></li>
					<li><a href="Formularios/login.php">Administrar</a></li>
					<li>
						<a href="mostrarcarrito.php">
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
                <img src="img/pic.jpg" alt="First slide image" class="d-block w-100">
                <div class="carousel-caption">
                    <h3></h3>
                    <p></p>
                </div>
            </div>

            <div class="item">
                <img src="img/pic1.jpg" alt="Second slide image" class="d-block w-100">
                <div class="carousel-caption">
                    <h3></h3>
                    <p></p>
                </div>
            </div>

            <div class="item">
                <img src="img/pic4.png" alt="Third slide image" class="d-block w-100">
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

    <section id="productos" class="seccion">
        <div class="container">
            <h2 class="titulo-seccion">Detalle de Producto</h2>
            
            <div class="container producto-container">
            <h4>Código: <?php echo $producto['IDProducto']; ?></h4>
            <h3><?php echo $producto['Nombre']; ?></h3>
            <h4><?php echo $producto['Descripcion']; ?></h4>
            <h4>Precio: C$ <?php echo $producto['Precio']; ?></h4>
            <br>
            <form action="productos.php" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $producto['IDProducto'];?>">
            <input type="hidden" name="nombre" id="nombre" value="<?php echo $producto['Nombre'];?>">
            <input type="hidden" name="precio" id="precio" value="<?php echo $producto['Precio'];?>">
            <input type="hidden" name="cantidad" id="cantidad" value="<?php echo 1; ?>">
            <button class="btn btn-success"
                name="btnAccion"
                value="Agregar"
                type="submit"
                >Agregar a Carrito
            </button>
            </form>
            <br>
            <img src="<?php echo $producto['Img1']; ?>" class="card-img-top" alt="<?php echo $producto['Img1']; ?>" style="width: 100%;">
            <img src="<?php echo $producto['Img2']; ?>" class="card-img-top" alt="<?php echo $producto['Img2']; ?>" style="width: 100%;">
            <img src="<?php echo $producto['Img3']; ?>" class="card-img-top" alt="<?php echo $producto['Img3']; ?>" style="width: 100%;">
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
                                <dt><a href="index.php">Inicio</a></dt>
                                <dt><a href="nosotros.php">Nosotros</a></dt>
                                <dt><a href="productos.php">Productos</a></dt>
                                <dt><a href="consulta.php">Consulta</a></dt>
                                <dt><a href="contactenos.php">Contáctenos</a></dt>
                                <dt><a href="Formularios/login.php">Administrar</a></dt>
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
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
</body>

</html>

<?php mysqli_close($enlace); ?>