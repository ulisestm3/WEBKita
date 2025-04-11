<?php include 'carrito.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KITA | Nosotros</title>
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
	<section class="seccion">

		<div class="container">
			<div class="col-md-12 text-center">
				<img src="img/Logo.jpg" alt="Logo" class="img-responsive center-block">
			</div>


			<div class="valores">
				<div class="col-md-12 col-md-offset-0 text-justify">
					<h2 class="titulo-seccion text-center">Quiénes Somos</h2>
					<hr>
				</div>
			</div>

			<div class="valores">
				<div class="container text-justify">
					<h3 class="titulo-seccion text-center">KITA</h3>
					<p>Representan naturaleza, frescura, tierra. buscamos resaltar la naturaleza por los productos orgánicos y cuidado del ambiente.</p><br>
					<p>
						<span style="color: #000000">“Kita es una marca innovadora. A nivel mundial los jabones naturales han tomado auge, las personas se están preocupando más por el cuidado de su salud, la formulación incluye ingredientes suavizantes, exfoliantes e hidratantes que no irritan la piel, son antioxidantes y contribuyen a darle mayor elasticidad, humedad y frescura, en comparación a los jabones comerciales, por tanto, la demanda de productos que demuestren propiedades benéficas para la piel está aumentando.”. </span>
					</p>

					<p>
						KITA nació con la misión de quitar lo innecesario y dejar solo lo mejor. Con ingredientes naturales y un proceso artesanal, cada jabón cuida tu piel y te conecta con la pureza de la naturaleza.
					</p>


					</span><br>
					<span style="color: #000000">¡La naturaleza esta en Kita! </span></p>
				</div>
			</div>
	</section>

	<section id="proposito-valores" class="seccion">
		<div class="container">

			<div class="Mision">
				<h3 class="titulo-seccion">Mision</h3>
				<p>
					La misión de <strong>KITA</strong> es brindar productos de higiene personal elaborados con ingredientes naturales y sostenibles, ofreciendo una alternativa saludable que contribuya al bienestar de las personas y al cuidado del medio ambiente.
				</p><br>

				<div Class="Vision">
					<h3 class="titulo-seccion">Vision</h3>
					<p>
						Ser la marca referente en productos de higiene natural en el mercado local nicaragüense, reconocida por su compromiso del cuidado de la piel y calidad.
					</p><br>

				</div>

				<div class="valores">
					<h3 class="titulo-seccion">✨ Nuestros Valores</h3><br>
					<ul class="lista-valores">
						<li><strong>Kuidado 🌿:</strong> Nos preocupamos por ti y por el planeta. Cada producto está diseñado para ofrecer un cuidado profundo y natural, respetando tanto tu piel como el medio ambiente.</li>
						<li><strong>Ingredientes Naturales 🍃:</strong> KITA ofrece jabones artesanales 100% naturales que nutren y protegen la piel, con ingredientes puros, para quienes buscan un cuidado saludable y sostenible sin químicos agresivos.</li>
						<li><strong>Ternura para la Piel 💚:</strong> Para quienes desean cuidar su piel de forma saludable y responsable,con productos libres de químicos dañinos,nuestro jabón natural Kita ofrece una experiencia suave, nutritiva y confiable gracias a su elaboración artesanal con ingredientes naturales.</li>
						<li><strong>Autenticidad ✨:</strong> Creemos en la transparencia y en la esencia única de cada producto. KITA refleja la belleza de lo natural, sin artificios, con calidad y honestidad.</li>
					</ul>
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