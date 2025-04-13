<?php
include 'carrito.php';

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
	<title>KITA | Productos</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
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

	<!--CONTENIDO DE LA PÁGINA-->

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
							echo '<p class="card-text"></p>';
							echo '<form action="detalleproducto.php" method="post">';
							echo '<input type="hidden" name="txtID" value="' . $producto['IDProducto'] . '">';
							echo '<button type="submit" class="btn btn-success">Ver detalle</button>';
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

	<!--CONTENIDO DE LA PÁGINA-->

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
							Teléfono: (+505) 2276-7289<br>
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